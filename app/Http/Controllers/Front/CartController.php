<?php

namespace App\Http\Controllers\Front;

use App\Shop\Carts\Requests\AddToCartRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Transformers\ShoppingCartTransformer;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    private $courierRepo;

    /**
     * CartController constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepositoryInterface $productRepository
     * @param CourierRepositoryInterface $courierRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CourierRepositoryInterface $courierRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->productRepo = $productRepository;
        $this->courierRepo = $courierRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartProducts = new ShoppingCartTransformer($this->cartRepo->getCartItems());
        $courier = $this->courierRepo->findCourierById(request()->session()->get('courierId', 1));
        $shippingFee = $this->cartRepo->getShippingFee($courier);

        return view('front.carts.cart', [
            'products' => $cartProducts->transform(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'shippingFee' => $shippingFee,
            'total' => $this->cartRepo->getTotal(2, $shippingFee)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddToCartRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddToCartRequest $request)
    {
        $product = $this->productRepo->findProductById($request->input('product'));
        $this->cartRepo->addToCart($product, $request->input('quantity'));

        $request->session()->flash('message', 'Add to cart successful');
        return redirect()->route('cart.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->cartRepo->updateQuantityInCart($id, $request->input('quantity'));

        request()->session()->flash('message', 'Update cart successful');
        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cartRepo->removeToCart($id);

        request()->session()->flash('message', 'Removed to cart successful');
        return redirect()->route('cart.index');
    }

    public function updateDelivery(int $orderId)
    {
        die($orderId);
    }
}
