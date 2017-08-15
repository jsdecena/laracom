<?php

namespace App\PaymentMethods\Paypal;

use App\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use Illuminate\Support\Collection;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalExpress
{
    private $apiContext;
    private $payer;
    private $amount;
    private $transactions = [];
    private $itemList;
    private $others;
    private $orderDetail;

    public function __construct(
        $clientId,
        $clientSecret,
        $mode = 'sandbox',
        $url = 'https://api.sandbox.paypal.com'
    )
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );

        $apiContext->setConfig(
            array(
                'mode' => $mode,
                'log.LogEnabled' => env('APP_DEBUG'),
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => env('APP_LOG_LEVEL'),
                'cache.enabled' => true,
                'cache.FileName' => storage_path('logs/paypal.cache')
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
        // ### Payer
        // A resource representing a Payer that funds a payment
        // For direct credit card payments, set payment method
        // to 'credit_card' and add an array of funding instruments.
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $this->payer = $payer;
    }

    public function setItems(Collection $products)
    {
        // ### Itemized information
        // (Optional) Lets you specify item wise information
        $items = [];
        foreach ($products as $product) {
            $item = new Item();
            $item->setName($product->name)
                ->setDescription($product->description)
                ->setQuantity($product->qty)
                ->setCurrency('PHP')
                ->setPrice($product->price);
            $items[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $this->itemList = $itemList;
    }

    public function setOtherFees($subtotal, $tax = 0, $shipping = 0)
    {
        $details = new Details();
        $details->setTax($tax)
            ->setSubtotal($subtotal);

        $this->others = $details;
    }

    public function setAmount($amt, $currency = 'PHP')
    {
        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($amt)
            ->setDetails($this->others);

        $this->amount = $amount;
    }

    public function setTransactions()
    {
        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it.
        $transaction = new Transaction();
        $transaction->setAmount($this->amount)
            ->setItemList($this->itemList)
            ->setDescription("Payment via Paypal")
            ->setInvoiceNumber(uniqid());

        $this->transactions = $transaction;
    }

    public function createPayment(string $returnUrl = '', string $cancelUrl = '')
    {
        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to sale 'sale'
        $payment = new Payment();
        $payment->setIntent("sale")
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

    public function executePayment(string $paymentId)
    {
        
    }
}