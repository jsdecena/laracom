<?php

namespace Laracommerce\Core\PaymentMethods\Paypal\Repositories;

use Laracommerce\Core\Addresses\Address;
use Laracommerce\Core\Addresses\Repositories\AddressRepository;
use Laracommerce\Core\Carts\Repositories\CartRepository;
use Laracommerce\Core\Carts\Requests\PayPalCheckoutExecutionRequest;
use Laracommerce\Core\Carts\ShoppingCart;
use Laracommerce\Core\Checkout\CheckoutRepository;
use Laracommerce\Core\Couriers\Courier;
use Laracommerce\Core\PaymentMethods\Payment;
use Laracommerce\Core\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use Laracommerce\Core\PaymentMethods\Paypal\PaypalExpress;
use Illuminate\Http\Request;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Payment as PayPalPayment;
use Ramsey\Uuid\Uuid;

class PayPalExpressCheckoutRepository implements PayPalExpressCheckoutRepositoryInterface
{
    /**
     * @var mixed
     */
    private $payPal;

    /**
     * PayPalExpressCheckoutRepository constructor.
     */
    public function __construct()
    {
        $payment = new Payment(new PaypalExpress(
            config('paypal.client_id'),
            config('paypal.client_secret'),
            config('paypal.mode'),
            config('paypal.api_url')
        ));

        $this->payPal = $payment->init();
    }

    /**
     * @return mixed
     */
    public function getApiContext()
    {
        return $this->payPal;
    }

    /**
     * @param Courier $courier
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Courier $courier, Request $request)
    {
        $cartRepo = new CartRepository(new ShoppingCart());
        $items = $cartRepo->getCartItemsTransformed();

        $addressRepo = new AddressRepository(new Address());

        $this->payPal->setPayer();
        $this->payPal->setItems($items);
        $this->payPal->setOtherFees(
            $cartRepo->getSubTotal(),
            $cartRepo->getTax(),
            $cartRepo->getShippingFee($courier)
        );
        $this->payPal->setAmount($cartRepo->getTotal(2, $cartRepo->getShippingFee($courier)));
        $this->payPal->setTransactions();

        $billingAddress = $addressRepo->findAddressById($request->input('billing_address'));
        $this->payPal->setBillingAddress($billingAddress);

        if ($request->has('shipping_address')) {
            $shippingAddress = $addressRepo->findAddressById($request->input('shipping_address'));
            $this->payPal->setShippingAddress($shippingAddress);
        }

        try {
            $response = $this->payPal->createPayment(
                route('checkout.execute', $request->except('_token')),
                route('checkout.cancel')
            );

            $redirectUrl = config('app.url');
            if ($response) {
                $redirectUrl = $response->links[1]->href;
            }
            return redirect()->to($redirectUrl);
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    public function execute(Request $request)
    {
        $payment = PayPalPayment::get($request->input('paymentId'), $this->payPal->getApiContext());
        $execution = $this->payPal->setPayerId($request->input('PayerID'));
        $trans = $payment->execute($execution, $this->payPal->getApiContext());

        $cartRepo = new CartRepository(new ShoppingCart);
        $transactions = $trans->getTransactions();

        foreach ($transactions as $transaction) {
            $checkoutRepo = new CheckoutRepository;
            $checkoutRepo->buildCheckoutItems([
                'reference' => Uuid::uuid4()->toString(),
                'courier_id' => $request->input('courier'),
                'customer_id' => auth()->user()->id,
                'address_id' => $request->input('billing_address'),
                'order_status_id' => 1,
                'payment' => $request->input('payment'),
                'discounts' => 0,
                'total_products' => $cartRepo->getSubTotal(),
                'total' => $cartRepo->getTotal(),
                'total_paid' => $transaction->getAmount()->getTotal(),
                'tax' => $cartRepo->getTax()
            ]);
        }

        $cartRepo->clearCart();
    }
}
