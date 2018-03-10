<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\OrderDetails\OrderProduct;
use App\Shop\OrderDetails\Repositories\OrderProductRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\PaymentMethods\Payment as PaypalPayment;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodNotFoundException;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\PaypalExpress;
use App\Shop\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    use ProductTransformable;

    private $cartRepo;
    private $courierRepo;
    private $paymentRepo;
    private $addressRepo;
    private $customerRepo;
    private $productRepo;
    private $orderRepo;
    private $paypal;
    private $courierId;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->paymentRepo = $paymentMethodRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = $this->customerRepo->findCustomerById($this->loggedUser()->id);

        $this->courierId = request()->session()->get('courierId', 1);
        $courier = $this->courierRepo->findCourierById($this->courierId);

        $shippingCost = $this->cartRepo->getShippingFee($courier);

        $addressId = request()->session()->get('addressId', 1);
        $paymentId = request()->session()->get('paymentId', 1);

        return view('front.checkout', [
            'customer' => $customer,
            'addresses' => $customer->addresses()->get(),
            'products' => $this->cartRepo->getCartItems(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'shipping' => $shippingCost,
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal(2, $shippingCost),
            'couriers' => $this->courierRepo->listCouriers(),
            'selectedCourier' => $this->courierId,
            'selectedAddress' => $addressId,
            'selectedPayment' => $paymentId,
            'payments' => $this->paymentRepo->listPaymentMethods()
        ]);
    }

    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws PaymentMethodNotFoundException
     * @codeCoverageIgnore
     */
    public function store(CartCheckoutRequest $request)
    {
        $method = $this->paymentRepo->findPaymentMethodById($request->input('payment'));

        $courierId = $request->session()->get('courierId', $request->input('courier'));
        $courier = $this->courierRepo->findCourierById($courierId);

        switch ($method->slug) {
            case 'paypal':

                $ppe = new PaypalExpress($method->client_id, $method->client_secret, $method->mode, $method->api_url);
                $payment = new PaypalPayment($ppe);
                $this->paypal = $payment->init();

                $this->paypal->setPayer();
                $this->paypal->setItems($this->getCartItems($this->cartRepo->getCartItems()));
                $this->paypal->setOtherFees(
                    $this->cartRepo->getSubTotal(),
                    $this->cartRepo->getTax(),
                    $this->cartRepo->getShippingFee($courier)
                );
                $this->paypal->setAmount($this->cartRepo->getTotal(2, $this->cartRepo->getShippingFee($courier)));
                $this->paypal->setTransactions();

                $billingAddress = $this->addressRepo->findAddressById($request->input('billing_address'));
                $this->paypal->setBillingAddress($billingAddress);

                if ($request->has('shipping_address')) {
                    $shippingAddress = $this->addressRepo->findAddressById($request->input('shipping_address'));
                    $this->paypal->setShippingAddress($shippingAddress);
                }

                try {
                    $response = $this->paypal->createPayment(
                        route('checkout.execute', $request->except('_token')),
                        route('checkout.cancel')
                    );

                    if ($response) {
                        $redirectUrl = $response->links[1]->href;
                        return redirect()->to($redirectUrl);
                    }
                } catch (PayPalConnectionException $e) {
                    throw new PaypalRequestError($e->getMessage());
                }
                break;
            default:
        }
    }

    public function getCartItems(Collection $collection)
    {
        return $collection->map(function (CartItem $item) {
            $productRepo = new ProductRepository(new Product());
            $product = $productRepo->findProductById($item->id);
            $item->product = $product;
            $item->cover = $product->cover;
            $item->description = $product->description;
            return $item;
        });
    }

    /**
     * Execute the PayPal payment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function execute(Request $request)
    {
        try {
            $apiContext = $this->paypal->getApiContext();

            $payment = Payment::get($request->input('paymentId'), $apiContext);
            $execution = $this->paypal->setPayerId($request->input('PayerID'));
            $trans = $payment->execute($execution, $apiContext);

            foreach ($trans->getTransactions() as $t) {
                $order = $this->orderRepo->create([
                    'reference' => Uuid::uuid4()->toString(),
                    'courier_id' => $request->input('courier'),
                    'customer_id' => Auth::id(),
                    'address_id' => $request->input('address'),
                    'order_status_id' => 1,
                    'payment_method_id' => $request->input('payment'),
                    'discounts' => 0,
                    'total_products' => $this->cartRepo->getSubTotal(),
                    'total' => $this->cartRepo->getTotal(),
                    'total_paid' => $t->getAmount()->getTotal(),
                    'tax' => $this->cartRepo->getTax()
                ]);

                $this->buildOrderDetails($order);
            }

            return redirect()->route('checkout.success');
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * Cancel page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        return view('front.checkout-cancel', ['data' => $request->all()]);
    }

    /**
     * Success page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('front.checkout-success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setCourier(Request $request)
    {
        $courier = $this->courierRepo->findCourierById($request->input('courierId'));
        $shippingCost = $this->cartRepo->getShippingFee($courier);

        request()->session()->put('courierId', $courier->id);

        return response()->json([
            'message' => 'Courier set successfully!',
            'courier' => $courier,
            'cartTotal' => $this->cartRepo->getTotal(2, $shippingCost)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAddress(Request $request)
    {
        $address = $this->addressRepo->findAddressById($request->input('addressId'));
        request()->session()->put('addressId', $address->id);

        return response()->json([
            'message' => 'Address set successfully!',
            'courier' => $address
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPayment(Request $request)
    {
        $payment = $this->paymentRepo->findPaymentMethodById($request->input('paymentId'));
        request()->session()->put('paymentId', $payment->id);

        return response()->json([
            'message' => 'Payment set successfully!',
            'payment' => $payment
        ]);
    }

    /**
     * Build the order details
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    private function buildOrderDetails(Order $order)
    {
        $this->cartRepo->getCartItems()
            ->each(function ($item) use ($order) {
                $product = $this->productRepo->find($item->id);
                $orderDetailRepo = new OrderProductRepository(new OrderProduct);
                $orderDetailRepo->createOrderDetail($order, $product, $item->qty);
            });

        return $this->clearCart();
    }

    /**
     * Clear the cart
     */
    private function clearCart()
    {
        $this->cartRepo->clearCart();
        return redirect()->route('checkout.success');
    }
}
