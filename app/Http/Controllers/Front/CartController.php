<?php

namespace App\Http\Controllers\Front;

use App\Cart\Requests\AddToCartRequest;
use App\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Products\Product;
use App\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Products\Repositories\ProductRepository;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    private $cartRepo;
    private $productRepo;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->cartRepo = $cartRepository;
        $this->productRepo = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productRepo = new ProductRepository(new Product());

        $items = collect($this->cartRepo->getCartItems())
            ->map(function (CartItem $item) use ($productRepo) {
                $product = $productRepo->findProductById($item->id);
                $item->product = $product;
                $item->cover = $product->cover;
                return $item;
        });

        return view('front.carts.cart', [
            'products' => $items,
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal()
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
}
