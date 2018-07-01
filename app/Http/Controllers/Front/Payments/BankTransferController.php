<?php

namespace App\Http\Controllers\Front\Payments;

use App\Http\Controllers\Controller;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Checkout\CheckoutRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class BankTransferController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var int $shipping
     */
    private $shipping;

    /**
     * BankTransferController constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepo = $cartRepository;
        $this->shipping = 0;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.bank-transfer-redirect', [
            'subtotal' => $this->cartRepo->getSubTotal(),
            'shipping' => $this->shipping,
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findByName('ordered');

        $checkoutRepo->buildCheckoutItems([
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => 1,
            'customer_id' => $request->user()->id,
            'address_id' => $request->input('billing_address'),
            'order_status_id' => $os->id,
            'payment' => strtolower(config('bank-transfer.name')),
            'discounts' => 0,
            'total_products' => $this->cartRepo->getSubTotal(),
            'total' => $this->cartRepo->getTotal(),
            'total_paid' => 0,
            'tax' => $this->cartRepo->getTax()
        ]);

        Cart::destroy();

        return redirect()->route('accounts', ['tab' => 'orders']);
    }
}