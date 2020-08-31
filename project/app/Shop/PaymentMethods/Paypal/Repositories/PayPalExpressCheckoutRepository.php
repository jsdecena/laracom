<?php

namespace App\Shop\PaymentMethods\Paypal\Repositories;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Checkout\CheckoutRepository;
use App\Shop\PaymentMethods\Payment;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\PaypalExpress;
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
     * @param $shippingFee
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Addresses\Exceptions\AddressNotFoundException
     */
    public function process($shippingFee, Request $request)
    {
        $cartRepo = new CartRepository(new ShoppingCart());
        $items = $cartRepo->getCartItemsTransformed();

        $addressRepo = new AddressRepository(new Address());

        $this->payPal->setPayer();
        $this->payPal->setItems($items);
        $this->payPal->setOtherFees(
            $cartRepo->getSubTotal(),
            $cartRepo->getTax(),
            $shippingFee
        );
        $this->payPal->setAmount($cartRepo->getTotal(2, $shippingFee));
        $this->payPal->setTransactions();

        $billingAddress = $addressRepo->findAddressById($request->input('billing_address'));
        $this->payPal->setBillingAddress($billingAddress);

        if ($request->has('shipping_address')) {
            $shippingAddress = $addressRepo->findAddressById($request->input('shipping_address'));
            $this->payPal->setShippingAddress($shippingAddress);
        }

        try {

            $response = $this->payPal->createPayment(
                route('checkout.execute', $request->except('_token', '_method')),
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
     *
     * @throws \Exception
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
                'courier_id' => 1,
                'customer_id' => $request->user()->id,
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
