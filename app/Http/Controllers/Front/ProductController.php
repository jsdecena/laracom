<?php

namespace App\Http\Controllers\Front;

use App\Shop\AttributeValues\AttributeValue;
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
        $list = $this->productRepo->searchProduct(request()->input('q'));

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products, 10)
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

        // Get all the attributes
        $combinations = $product->attributes()->get()
            ->pluck('attributesValues')
            ->flatten()
            ->unique()
            ->groupBy(function (AttributeValue $av) {
                return $av->attribute->name;
            })
            ->map(function (Collection $collection) {
                return $collection->map(function (AttributeValue $av) {
                    return [
                        'attribute' => $av->attribute,
                        'value' => $av->value
                    ];
                })->unique()->all();
            })->all();

        // dd($combinations);

        return view('front.products.product', compact(
            'product',
            'images',
            'combinations'
        ));
    }
}
