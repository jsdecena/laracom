<?php

namespace App\Http\Controllers\Front;

use App\Shop\Carts\Requests\AddToCartRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepo;

    /**
     * CartController constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepositoryInterface $productRepository
     * @param CourierRepositoryInterface $courierRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CourierRepositoryInterface $courierRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->productRepo = $productRepository;
        $this->courierRepo = $courierRepository;
        $this->productAttributeRepo = $productAttributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courier = $this->courierRepo->findCourierById(request()->session()->get('courierId', 1));
        $shippingFee = $this->cartRepo->getShippingFee($courier);

        return view('front.carts.cart', [
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
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
        $options = [];

        $product = $this->productRepo->findProductById($request->input('product'));

        if(!is_null($request->input('allCombinations'))) {
            $allCombinations = json_decode($request->input('allCombinations'), true);

            $currentCombination = [];
            foreach($request->all() as $key => $value) {
                if (strpos($key, '-attr') !== false) {
                    $newKey = str_replace('-attr', '', $key);
                    $currentCombination[$newKey] = $value;
                }
            }

            $isVariationAvailable = $this->checkIfCombinationExists($allCombinations, $currentCombination);

            if(is_array($isVariationAvailable)) {
                $pa = $isVariationAvailable['productAttributeId'];
                $productAttribute = $this->productAttributeRepo->findProductAttributeById($pa);

                $productRepo = new ProductRepository($product);
                $combination = $productRepo->findProductCombination($productAttribute);

                $options = $combination->all();

                if (!is_null($productAttribute->price)) {
                    $product->price = $productAttribute->price;
                }
            } else {
                return \Redirect::back()->withErrors('Sorry the selected combination is not available, please try a different combination.');
            }
        }

        if(isset($request['sub-option']) && !is_null($request['sub-option'])) {
            $extraAmount = (int)explode('-', $request['sub-option'])[1];
            $product->price = $product->price + $extraAmount;
        }

        $this->cartRepo->addToCart($product, $request->input('quantity'), $options);

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

    /**
     * @param $allCombinations
     * @param $currentCombination
     * @return mixed
     */
    protected function checkIfCombinationExists($allCombinations, $currentCombination)
    {
        foreach ($allCombinations as $key => $value) {
            $comboDiff = array_diff($currentCombination, $value);
            if (empty($comboDiff)) {
                return [
                    'productAttributeId' => $key,
                ];
            }
        }

        return false;
    }
}
