<?php

namespace App\Shop\Carts\Transformers;

use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;

class ShoppingCartTransformer
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * ShoppingCartService constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function transform()
    {
        return $this->collection->map(function (CartItem $item) {
            $productRepo = new ProductRepository(new Product());
            $product = $productRepo->findProductById($item->id);
            $item->product = $product;
            $item->cover = $product->cover;
            return $item;
        });
    }

    /**
     * @return mixed
     */
    public function getCartItems()
    {
        return $this->collection->map(function (CartItem $item) {
                $productRepo = new ProductRepository(new Product());
                $product = $productRepo->findProductById($item->id);
                $item->product = $product;
                $item->cover = $product->cover;
                $item->description = $product->description;
                return $item;
            });
    }
}