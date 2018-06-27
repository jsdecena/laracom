<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Requests\PayPalCheckoutExecutionRequest;
use App\Shop\Carts\Requests\StripeExecutionRequest;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use App\Shop\PaymentMethods\Stripe\StripeRepository;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPal\Exception\PayPalConnectionException;

class CheckoutController extends Controller
{
    use ProductTransformable;

    private $cartRepo;
    private $courierRepo;
    private $addressRepo;
    private $customerRepo;
    private $productRepo;
    private $orderRepo;
    private $courierId;
    private $payPal;

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
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'shippingFee' => $shippingFee
        ]);
    }

    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @codeCoverageIgnore
     * @throws \App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException
     */
    public function store(CartCheckoutRequest $request)
    {
        $shippingFee = 0;

        switch ($request->input('payment')) {
            case 'paypal':
                return $this->payPal->process($shippingFee, $request);
                break;
            case 'stripe':

                $details = [
                    'description' => 'Stripe payment',
                    'metadata' => $this->cartRepo->getCartItems()->all()
                ];

                $customer = $this->customerRepo->findCustomerById(auth()->id());
                $customerRepo = new CustomerRepository($customer);
                $customerRepo->charge($this->cartRepo->getTotal(2, $shippingFee), $details);
                break;
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
}
