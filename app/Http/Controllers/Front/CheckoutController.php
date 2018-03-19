<?php

namespace App\Http\Controllers\Front;

use Laracommerce\Core\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use Laracommerce\Core\Cart\Requests\CartCheckoutRequest;
use Laracommerce\Core\Carts\Repositories\Interfaces\CartRepositoryInterface;
use Laracommerce\Core\Carts\Requests\PayPalCheckoutExecutionRequest;
use Laracommerce\Core\Carts\Requests\StripeExecutionRequest;
use Laracommerce\Core\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use Laracommerce\Core\Customers\Repositories\CustomerRepository;
use Laracommerce\Core\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Laracommerce\Core\OrderDetails\Repositories\Interfaces\OrderProductRepositoryInterface;
use Laracommerce\Core\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use Laracommerce\Core\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use Laracommerce\Core\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
use Laracommerce\Core\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use Laracommerce\Core\PaymentMethods\Stripe\StripeRepository;
use Laracommerce\Core\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Laracommerce\Core\Products\Transformations\ProductTransformable;
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
    private $orderProductRepo;
    private $payPal;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        OrderProductRepositoryInterface $orderProductRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;
        $this->orderProductRepo = $orderProductRepository;

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
     * @return \Illuminate\Http\RedirectResponse
     * @codeCoverageIgnore
     */
    public function store(CartCheckoutRequest $request)
    {
        $courier = $this->courierRepo->findCourierById($request->input('courier'));
        $shippingFee = $this->cartRepo->getShippingFee($courier);

        switch ($request->input('payment')) {
            case 'paypal':
                return $this->payPal->process($courier, $request);
                break;
            case 'stripe':

                $details = [
                    'description' => 'Stripe payment',
                    'metadata' => $this->cartRepo->getCartItems()->all()
                ];

                $customerRepo = new CustomerRepository($this->loggedUser());
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
            $customer = auth()->user();
            $stripeRepo = new StripeRepository($customer);

            return $stripeRepo->execute(
                $request->all(),
                Cart::total(),
                Cart::tax()
            );
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
