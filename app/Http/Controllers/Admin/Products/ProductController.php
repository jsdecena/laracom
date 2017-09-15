<?php

namespace App\Http\Controllers\Admin\Products;

use App\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Products\Product;
use App\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Products\Requests\CreateProductRequest;
use App\Products\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Products\Transformations\ProductTransformable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ProductTransformable;

    private $productRepo;
    private $categoryRepo;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q')) {
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
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $this->productRepo->createProduct($request->all());

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = $this->productRepo->findProductById($id);

        return view('admin.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = $this->productRepo->findProductById($id);

        $productCategories = $product->categories;

        $ids = [];
        foreach ($productCategories as $category) {
            $ids[] = $category->id;
        }

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $this->categoryRepo->listCategories('name', 'asc'),
            'selectCategories' => $ids
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productRepo->findProductById($id);
        $this->productRepo->updateProduct($request->except('categories', '_token', '_method'), $product->id);

        if ($request->has('categories')) {
            $collection = collect($request->input('categories'));
            $product->categories()->sync($collection->all());
        } else {
            $product->categories()->detach($product);
        }

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.products.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->findProductById($id);
        $product->categories()->sync([]);
        try {
            $this->productRepo->delete($id);
        } catch (QueryException $e) {
            request()->session()->flash('error', 'Ooops, the product (name: '. $product->name .' sku: '. $product->sku .')" has order. You cannot delete this.');
            return redirect()->back();
        }


        request()->session()->flash('message', 'Delete successful');
        return redirect()->back();
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
}
