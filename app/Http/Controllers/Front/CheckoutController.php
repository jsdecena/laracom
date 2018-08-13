<?php

namespace App\Http\Controllers\Front;

use App\Mail\Order;
use App\Orders;
use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Requests\PayPalCheckoutExecutionRequest;
use App\Shop\Carts\Requests\StripeExecutionRequest;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use App\Shop\PaymentMethods\Stripe\StripeRepository;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Traits\PayuTrait;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PayPal\Exception\PayPalConnectionException;
use Tzsk\Payu\Facade\Payment;
use App\Shop\Carts\Requests\PayUCheckoutRequest;
use Softon\Indipay\Facades\Indipay;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    use ProductTransformable, PayuTrait;
    private $cartRepo;
    private $courierRepo;
    private $addressRepo;
    private $customerRepo;
    private $productRepo;
    private $orderRepo;
    private $courierId;
    private $payPal;
    public $paymentFlag = false;
    public $orderId;
    public $shipmentStatus;
    public $shipmentStatusMessage;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;

        $payPalRepo = new PayPalExpressCheckoutRepository();
        $this->payPal = $payPalRepo;
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
        $paymentId = request()->session()->get('paymentName', 'paypal');

        // Get payees
        $paymentMethods = config('payees.name');
        $payees = explode(',', $paymentMethods);

        $paymentGateways = collect($payees)->transform(function ($name) {
            return config($name);
        })->filter()->all();

        $courier = $this->courierRepo->findCourierById(1);
        $shippingFee = $this->cartRepo->getShippingFee($courier);

        return view('front.checkout', [
            'customer'        => $customer,
            'addresses'       => $customer->addresses()->get(),
            'products'        => $this->cartRepo->getCartItems(),
            'subtotal'        => $this->cartRepo->getSubTotal(),
            'shipping'        => $shippingCost,
            'tax'             => $this->cartRepo->getTax(),
            'total'           => $this->cartRepo->getTotal(2, $shippingCost),
            'couriers'        => $this->courierRepo->listCouriers(),
            'selectedCourier' => $this->courierId,
            'selectedAddress' => $addressId,
            'selectedPayment' => $paymentId,
            'payments'        => $paymentGateways,
            'cartItems'       => $this->cartRepo->getCartItemsTransformed(),
            'shippingFee'     => $shippingFee
        ]);
    }

    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @codeCoverageIgnore
     * @throws \App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException
     */
    public function store(CartCheckoutRequest $request)
    {
        $courier = $this->courierRepo->findCourierById(1);
        $shippingFee = $this->cartRepo->getShippingFee($courier);
        switch ($request->get('payment')) {
            case 'paypal':
                return $this->payPal->process($courier, $request);
                break;
            case 'stripe':

                $details = [
                    'description' => 'Stripe payment',
                    'metadata'    => $this->cartRepo->getCartItems()->all()
                ];
                $customer = $this->customerRepo->findCustomerById(auth()->id());
                $customerRepo = new CustomerRepository($customer);
                $customerRepo->charge($this->cartRepo->getTotal(2, $shippingFee), $details);
                break;
            case 'payu money':
                $data = $this->chargeThroughPayUMoney($request);
                return Payment::make($data, function ($then) {
                    $then->redirectTo('payment/status/page'); # Your Status page endpoint.
                });
//                if($this->shipmentStatus)
//                {
//                    return Payment::make($data, function ($then) {
//                        $then->redirectTo('payment/status/page'); # Your Status page endpoint.
//                    });
//                }else{
////                    return view('layouts.errors.404',['error'=>$this->shipmentStatusMessage]);
//                }



            default:
        }
    }

    /**
     * Execute the PayPal payment
     *
     * @param PayPalCheckoutExecutionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function executePayPalPayment(PayPalCheckoutExecutionRequest $request)
    {
        try {
            $this->payPal->execute($request);
            $this->cartRepo->clearCart();

            return redirect()->route('checkout.success');
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param StripeExecutionRequest $request
     * @return \Stripe\Charge
     */
    public function charge(StripeExecutionRequest $request)
    {
        try {
            $customer = $this->customerRepo->findCustomerById(auth()->id());
            $stripeRepo = new StripeRepository($customer);

            $stripeRepo->execute(
                $request->all(),
                Cart::total(),
                Cart::tax()
            );

            return redirect()->route('checkout.success')->with('message', 'Stripe payment successful!');
        } catch (StripeChargingErrorException $e) {
            Log::info($e->getMessage());

            return redirect()->route('checkout.index')->with('error', 'There is a problem processing your request.');
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

    public function chargeThroughPayUMoney($request)
    {
        $productName = [];
        $courier = $this->courierRepo->findCourierById(1);
        $shippingFee = $this->cartRepo->getShippingFee($courier);
        $cartItems = $this->cartRepo->getCartItems()->all();
        foreach ($cartItems as $items) {
            $productName[] = $items->name;
        }
        $productInfo = implode(",", $productName);
        $totalAmountToCharge = $this->cartRepo->getTotal(2, $shippingFee);
        $whatTheAuth = Auth::user();
        $name = $whatTheAuth->name;
        $email = $whatTheAuth->email;
        $request->request->add(['amount' => $totalAmountToCharge]);
        $request->request->add(['userId' => $whatTheAuth->id]);
        $request->request->add(['total_products' => count($cartItems)]);
        $request->request->add(['productinfo' => $productInfo]);
        $totalAmountToCharge = ceil(str_replace(',', '', $totalAmountToCharge));
        $attributes = [
            'txnid'       => strtoupper(str_random(8)), # Transaction ID.
            'amount'      => (int)$totalAmountToCharge,
            'productinfo' => $productInfo,
            'firstname'   => $name, # Payee Name.
            'email'       => $email, # Payee Email Address.
            'phone'       => "9876543210", # Payee Phone Number.
        ];
        $this->captureOrderData($request);

        return $attributes;
    }

    public function chargeThroughCOD()
    {

    }

    public function getPayUStatus()
    {

    }

    public function captureOrderData($request)
    {
        $amount = (float)str_replace(',', '', $request->get('amount'));
        $orderData = [
            'reference'       => null,
            'courier_id'      => 1,
            'customer_id'     => $request->get('userId'),
            'address_id'      => $request->get('delivery_address'),
            'order_status_id' => 1,
            'payment'         => $request->get('payment'),
            'discounts'       => $request->get('discounts') ?? null,
            'total_products'  => $request->get('total_products'),
            'tax'             => $request->get('tax') ?? null,
            'total'           => $amount,
            'invoice'         => '',
            'total_paid'      => $amount,
        ];
        $orderDataSaved = $this->orderRepo->create($orderData);
//        Mail::to("rohitnishantjangral@gmail.com")->send(new Order($orderData));
        $orderData[ 'total_products' ] = $request->get('total_products');
        $orderData[ 'product_info' ] = $request->get('productinfo');
        $orderToShip = array_merge($orderData, $orderDataSaved->toArray());
        $this->orderId = $orderToShip['id'];
        $getToken = $this->moveToShipment();
        $status = $this->setOrder($getToken, $orderToShip);
        $status = collect($status[0]);
        if($status->has('error'))
        {
            $this->shipmentStatus = false;
            $this->shipmentStatusMessage = $status->get('error');
        }

    }
}
