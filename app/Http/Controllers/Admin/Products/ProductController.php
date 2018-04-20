<?php

namespace App\Http\Controllers\Admin\Products;

use Laracommerce\Core\Attributes\Repositories\AttributeRepositoryInterface;
use Laracommerce\Core\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use Laracommerce\Core\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use Laracommerce\Core\ProductAttributes\ProductAttribute;
use Laracommerce\Core\Products\Product;
use Laracommerce\Core\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Laracommerce\Core\Products\Repositories\ProductRepository;
use Laracommerce\Core\Products\Requests\CreateAttributeCombination;
use Laracommerce\Core\Products\Requests\CreateProductRequest;
use Laracommerce\Core\Products\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use Laracommerce\Core\Products\Transformations\ProductTransformable;
use Laracommerce\Core\Tools\UploadableTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracommerce\Core\Warehouse\Repositories\WarehouseRepository;
use Laracommerce\Core\Warehouse\Warehouse;

class ProductController extends Controller
{
    use ProductTransformable, UploadableTrait;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepo;

    /**
     * @var AttributeValueRepositoryInterface
     */
    private $attributeValueRepository;

    private $productAttribute;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     * @param ProductAttribute $productAttribute
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttribute $productAttribute
    ) {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->attributeRepo = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttribute = $productAttribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        return view('admin.products.list', [
            'products' => $this->productRepo->paginateArrayResults($products, 10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories' => $this->categoryRepo->listCategories('name', 'asc')->where('parent_id', 1),
            'selectedIds' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->except('_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->productRepo->saveCoverImage($request->file('cover'));
        }

        $product = $this->productRepo->createProduct($data);
        $this->saveProductImages($request, $product);

        $this->updateStockLevels($request->get('warehouse', 'default'), $product);

        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        } else {
            $product->categories()->detach();
        }

        $request->session()->flash('message', 'Create successful');
        return redirect()->route('admin.products.edit', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('admin.products.show', ['product' => $this->productRepo->findProductById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        $productAttributes = $product->attributes()->get();
        $qty = $productAttributes->map(function ($item) {
            return $item->quantity;
        })->sum();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productAttributes->where('id', request()->input('pa'))->first();
            $pa->attributesValues()->detach();
            $pa->delete();

            if ($product->attributes->count() === 0) {
                // lets create a stock level for a product without any attributes
                $this->updateStockLevels(request()->get('warehouse', 'default'), $product);
            }

            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }

        return view('admin.products.edit', [
            'product' => $product,
            'images' => $product->images()->get(['src']),
            'categories' => $this->categoryRepo->listCategories('name', 'asc')->where('parent_id', 1),
            'selectedIds' => $product->categories()->pluck('category_id')->all(),
            'attributes' => $this->attributeRepo->listAttributes(),
            'productAttributes' => $productAttributes,
            'qty' => $qty
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productRepo->findProductById($id);

        if ($request->has('attributeValue')) {
            $this->saveProductCombinations($request, $product);
            $request->session()->flash('message', 'Attribute combination created successful');
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1]);
        }

        $data = $request->except('categories', '_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->productRepo->saveCoverImage($request->file('cover'));
        }

        $this->saveProductImages($request, $product);

        $this->productRepo->updateProduct($data, $id);

        if ($product->attributes->count() === 0) {
            // we have to load once again $product with current quantity and price to store the stock level.
            $product = $this->productRepo->findProductById($id);
            $this->updateStockLevels($request->get('warehouse', 'default'), $product);
        }

        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        } else {
            $product->categories()->detach();
        }

        $request->session()->flash('message', 'Update successful');

        return redirect()->route('admin.products.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->findProductById($id);
        $product->categories()->sync([]);

        $this->productRepo->delete($id);

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.products.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->productRepo->deleteFile($request->only('product', 'image'), 'uploads');
        request()->session()->flash('message', 'Image delete successful');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeThumbnail(Request $request)
    {
        $this->productRepo->deleteThumb($request->input('src'));
        request()->session()->flash('message', 'Image delete successful');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Product $product
     */
    private function saveProductImages(Request $request, Product $product)
    {
        if ($request->hasFile('image')) {
            $this->productRepo->saveProductImages(collect($request->file('image')), $product);
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return boolean
     */
    private function saveProductCombinations(Request $request, Product $product)
    {
        $fields = $request->only('productAttributeQuantity', 'productAttributePrice');

        if ($errors = $this->validateFields($fields)) {
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1])
                ->withErrors($errors);
        }

        $quantity = $fields['productAttributeQuantity'];
        $price = $fields['productAttributePrice'];

        $attributeValues = $request->input('attributeValue');
        $productRepo = new ProductRepository($product);
        $productAttribute = $productRepo->saveProductAttributes(new ProductAttribute(compact('quantity', 'price')));

        $stock = $this->updateStockLevels($request->get('warehouse', 'default'), $product, $productAttribute);

        // save the combinations
        return collect($attributeValues)->each(function ($attributeId) use ($productRepo, $productAttribute) {
            $attribute = $this->attributeValueRepository->find($attributeId);
            return $productRepo->saveCombination($productAttribute, $attribute);
        })->count();
    }

    /**
     * @param string $warehouseName
     * @param Product $product
     * @param ProductAttribute|null $productAttribute
     *
     * @return \Laracommerce\Core\Warehouse\Stock
     */
    private function updateStockLevels(string $warehouseName, Product $product, ProductAttribute $productAttribute = null)
    {
        $warehouseRepo = new WarehouseRepository(new Warehouse());
        $warehouse = $warehouseRepo->getWarehouseByName($warehouseName);
        $warehouseRepo = new WarehouseRepository($warehouse);

        return $warehouseRepo->saveStock($product, $productAttribute);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator|null
     */
    private function validateFields(array $data)
    {
        $validator = Validator::make($data, [
            'productAttributeQuantity' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
    }
}
