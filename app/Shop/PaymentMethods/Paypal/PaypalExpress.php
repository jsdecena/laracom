<?php

namespace App\Shop\PaymentMethods\Paypal;

use App\Shop\Addresses\Address;
use App\Shop\Carts\ShoppingCart;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use Illuminate\Support\Collection;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

/**
 * Class PaypalExpress
 * @package App\Shop\PaymentMethods\Paypal
 * @codeCoverageIgnore
 *
 * @todo Make a test for this
 */
class PaypalExpress
{
    private $apiContext;
    private $payer;
    private $amount;
    private $transactions = [];
    private $itemList;
    private $others;

    public function __construct($clientId, $clientSecret, $mode)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential($clientId, $clientSecret)
        );

        $apiContext->setConfig(
            array(
                'mode' => $mode,
                'log.LogEnabled' => env('APP_DEBUG'),
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => env('APP_LOG_LEVEL'),
                'cache.enabled' => true,
                'cache.FileName' => storage_path('logs/paypal.cache'),
                'http.CURLOPT_SSLVERSION' => CURL_SSLVERSION_TLSv1
            )
        );

        $this->apiContext = $apiContext;
    }

    /**
     * Returns the Paypal API Context
     *
     * @return ApiContext
     */
    public function getApiContext()
    {
        return $this->apiContext;
    }

    public function setPayer()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $this->payer = $payer;
    }

    /**
     * @param Collection $products
     */
    public function setItems(Collection $products)
    {
        $items = [];
        foreach ($products as $product) {
            $item = new Item();
            $item->setName($product->name)
                ->setDescription($product->description)
                ->setQuantity($product->qty)
                ->setCurrency(ShoppingCart::$defaultCurrency)
                ->setPrice($product->price);
            $items[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $this->itemList = $itemList;
    }

    /**
     * @param $subtotal
     * @param int $tax
     * @param $shipping
     */
    public function setOtherFees($subtotal, $tax = 0, $shipping)
    {
        $details = new Details();
        $details->setTax($tax)
            ->setSubtotal($subtotal)
            ->setShipping($shipping);

        $this->others = $details;
    }

    /**
     * @param $amt
     */
    public function setAmount($amt)
    {
        $amount = new Amount();
        $amount->setCurrency(ShoppingCart::$defaultCurrency)
            ->setTotal($amt)
            ->setDetails($this->others);

        $this->amount = $amount;
    }

    public function setTransactions()
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount)
            ->setItemList($this->itemList)
            ->setDescription('Payment via Paypal')
            ->setInvoiceNumber(uniqid());

        $this->transactions = $transaction;
    }

    /**
     * @param string $returnUrl
     * @param string $cancelUrl
     *
     * @return Payment
     */
    public function createPayment(string $returnUrl, string $cancelUrl)
    {
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($this->payer)
            ->setTransactions([$this->transactions]);

        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);

        $payment->setRedirectUrls($redirectUrls);

        try {
            return $payment->create($this->apiContext);
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        }
    }

    /**
     * @param string $payerID
     * @return PaymentExecution
     */
    public function setPayerId(string $payerID)
    {
        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);
        return $execution;
    }

    /**
     * @param Address $address
     * @return InvoiceAddress
     */
    public function setBillingAddress(Address $address)
    {
        $billingAddress = new InvoiceAddress();
        $billingAddress->line1 = $address->address_1;
        $billingAddress->line2 = $address->address_2;
        $billingAddress->city = $address->city;
        $billingAddress->state = $address->state_code;
        $billingAddress->postal_code = $address->zip;
        $billingAddress->country_code = $address->country->iso;

        return $billingAddress;
    }

    /**
     * @param Address $address
     * @return ShippingAddress
     */
    public function setShippingAddress(Address $address)
    {
        $shipping = new ShippingAddress();
        $shipping->line1 = $address->address_1;
        $shipping->line2 = $address->address_2;
        $shipping->city = $address->city;
        $shipping->state = $address->state_code;
        $shipping->postal_code = $address->zip;
        $shipping->country_code = $address->country->iso;

        return $shipping;
    }
}
