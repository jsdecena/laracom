<?php

namespace App\Http\Controllers\Front;

use App\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     * Get the product
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProduct(string $slug)
    {
        return view('front.products.product', [
            'product' =>  $this->productRepo->findProductBySlug(['slug' => $slug])
        ]);
    }

    public function removeImage()
    {
        //
    }
}
