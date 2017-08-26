<?php

namespace App\Http\Controllers\Admin\Products;

use App\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Products\Repositories\ProductRepository;
use App\Products\Requests\CreateProductRequest;
use App\Products\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
        $collection = $this->productRepo->listProducts('id', true);

        return view('admin.products.list', [
            'products' => $this->productRepo->paginateArrayResults($collection, 10)
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

        $update = new ProductRepository($product);

        $update->updateProduct($request->except('categories'));

        if ($request->has('categories')) {
            $collection = collect($request->input('categories'));
            $categories = $collection->all();
            $update->syncCategories($categories);
        } else {
            $update->detachCategories($product);
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
}
