<?php

namespace App\Http\Controllers\Front;

use App\Shop\AttributeValues\AttributeValue;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    use ProductTransformable;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $list = $this->productRepo->listProducts();

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products->all(), 10)
        ]);
    }

    /**
     * Get the product
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);
        $images = $product->images()->get();
        $category = $product->categories()->first();
        $productAttributes = $product->attributes;
        $combinations = $combinationElements = $priceRange = $allPossibleCombinations = [];
        foreach($productAttributes as $productAttribute) {
            $priceRange[$productAttribute->id][] = $productAttribute->price;
            foreach($productAttribute->attributesValues as $value) {
                $combinations[$value->attribute->name][] = $value->value;
                $allPossibleCombinations[$productAttribute->id][$value->attribute->name] = $value->value;
            }
        }
        $allCombinations = null;
        if(!empty($allPossibleCombinations)) {
            $allCombinations = json_encode($allPossibleCombinations);
        }
        foreach($combinations as $key => $value) {
            $combinationElements[$key] = array_unique($value);
        }
        $comboPriceRange = null;
        if(!empty($priceRange)) {
            $highPrice = number_format(max($priceRange)[0]);
            $lowestPrice = number_format(min($priceRange)[0]);
            $comboPriceRange = $lowestPrice." - ".$highPrice;
        }
        return view('front.products.product', compact(
            'product',
            'images',
            'productAttributes',
            'category',
            'combos',
            'combinationElements',
            'comboPriceRange',
            'allCombinations'
        ));
    }
}
