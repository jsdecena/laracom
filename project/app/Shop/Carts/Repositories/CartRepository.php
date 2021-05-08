<?php

namespace App\Shop\Carts\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Carts\Exceptions\ProductInCartNotFoundException;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Gloudemans\Shoppingcart\Cart;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Illuminate\Support\Collection;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    /**
     * CartRepository constructor.
     * @param ShoppingCart $cart
     */
    public function __construct(ShoppingCart $cart)
    {
        $this->model = $cart;
    }

    /**
     * @param Product $product
     * @param int $int
     * @param array $options
     * @return CartItem
     */
    public function addToCart(Product $product, int $int, $options = []) : CartItem
    {
        return $this->model->add($product, $int, $options);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCartItems() : Collection
    {
        return $this->model->content();
    }

    /**
     * @param string $rowId
     *
     * @throws ProductInCartNotFoundException
     */
    public function removeToCart(string $rowId)
    {
        try {
            $this->model->remove($rowId);
        } catch (InvalidRowIDException $e) {
            throw new ProductInCartNotFoundException('Product in cart not found.');
        }
    }

    /**
     * Count the items in the cart
     *
     * @return int
     */
    public function countItems() : int
    {
        return $this->model->count();
    }

    /**
     * Get the sub total of all the items in the cart
     *
     * @param int $decimals
     * @return float
     */
    public function getSubTotal(int $decimals = 2)
    {
        return $this->model->subtotal($decimals, '.', '');
    }

    /**
     * Get the final total of all the items in the cart minus tax
     *
     * @param int $decimals
     * @param float $shipping
     * @return float
     */
    public function getTotal(int $decimals = 2, $shipping = 0.00)
    {
        return $this->model->total($decimals, '.', '', $shipping);
    }

    /**
     * @param string $rowId
     * @param int $quantity
     * @return CartItem
     */
    public function updateQuantityInCart(string $rowId, int $quantity) : CartItem
    {
        return $this->model->update($rowId, $quantity);
    }

    /**
     * Return the specific item in the cart
     *
     * @param string $rowId
     * @return \Gloudemans\Shoppingcart\CartItem
     */
    public function findItem(string $rowId) : CartItem
    {
        return $this->model->get($rowId);
    }

    /**
     * Returns the tax
     *
     * @param int $decimals
     * @return float
     */
    public function getTax(int $decimals = 2)
    {
        return $this->model->tax($decimals);
    }

    /**
     * @param Courier $courier
     * @return mixed
     */
    public function getShippingFee(Courier $courier)
    {
        return number_format($courier->cost, 2);
    }

    /**
     * Clear the cart content
     */
    public function clearCart()
    {
        $this->model->destroy();
    }

    /**
     * @param Customer $customer
     * @param string $instance
     */
    public function saveCart(Customer $customer, $instance = 'default')
    {
        $this->model->instance($instance)->store($customer->email);
    }

    /**
     * @param Customer $customer
     * @param string $instance
     * @return Cart
     */
    public function openCart(Customer $customer, $instance = 'default')
    {
        $this->model->instance($instance)->restore($customer->email);
        return $this->model;
    }

    /**
     * @return Collection
     */
    public function getCartItemsTransformed() : Collection
    {
        return $this->getCartItems()->map(function ($item) {
            $productRepo = new ProductRepository(new Product());
            $product = $productRepo->findProductById($item->id);
            $item->product = $product;
            $item->cover = $product->cover;
            $item->description = $product->description;
            return $item;
        });
    }
}
