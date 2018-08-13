<?php
/**
 * Created by PhpStorm.
 * User: rohit
 * Date: 3/8/18
 * Time: 1:48 PM
 */

namespace App\Traits;

use App\PayuMoney;
use App\Shop\Cities\City;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Facades\Session;
use Softon\Indipay\Facades\Indipay;
use Tzsk\Payu\Facade\Payment;
use Adil\Shyplite\Shyplite;
use Illuminate\Support\Facades\Auth;

trait PayuTrait
{

    public function pay($data)
    {
        return Payment::make($data, function ($then) {

            $then->redirectTo('payment/status/page'); # Your Status page endpoint.
        });

    }

    public function status()
    {
        $payment = Payment::capture();
        $data = [
            "txnid"          => $payment->get('txnid'),
            "mihpayid"       => $payment->get('mihpayid'),
            "firstname"      => $payment->get('firstname'),
            "email"          => $payment->get('email'),
            "phone"          => $payment->get('phone'),
            "amount"         => $payment->get('amount'),
            "status"         => $payment->get('status'),
            "unmappedstatus" => $payment->get('unmappedstatus'),
            "mode"           => $payment->get('mode'),
            "bank_ref_num"   => $payment->get('bank_ref_num'),
            "bankcode"       => $payment->get('bankcode'),
            "data"           => $payment->get('data'),
            "account"        => $payment->get('account'),
        ];
        PayuMoney::Create($data);
        if ($payment->get('status') == 'success') {
            foreach(Session::all()['cart'] as $carts)
            {
                foreach ($carts as $cart)
                {
                   \Cart::remove($cart->rowId);
                }
            }
//            $this->orderRepo->update(['order_status_id' => 1],$this->orderId);
//            $this->paymentFlag = true;
            return redirect('/accounts');
        } elseif ($payment->get('status') == 'failure') {
            return view('layouts.front.payu_status', ['payu' => $payment]);
//            $this->orderRepo->update(['order_status_id' => 3],$this->orderId);
        }


    }

    protected function moveToShipment()
    {
        list($email, $password, $timestamp, $appID, $authtoken) = $this->shypLiteAuth();
        $ch = curl_init();

        $header = array(
            "x-appid: $appID",
            "x-timestamp: $timestamp",
            "Authorization: $authtoken"
        );

        curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "emailID=$email&password=$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $secretToken = json_decode($server_output)->userToken;

        return $secretToken;

    }


    public function setOrder($getToken, $orderToShip)
    {
        $addressObject = $this->addressRepo->findAddressById($orderToShip[ 'address_id' ]);
        $address = $addressObject->address_1 . " " . $addressObject->address_2 ;
        $city = City::find($addressObject->city_id) ?? 'Mumbai';
        $timestamp = time();
        $appID = 1222;
        $key = '0Qi2SIbfoCU=';
        $secret = trim($getToken);

        $sign = "key:" . $key . "id:" . $appID . ":timestamp:" . $timestamp;
        $authToken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
        $data = [
            'orders' => [
                [
                    "orderId"         => $orderToShip[ 'id' ],
                    "customerName"    => Auth::User()->name,
                    "customerAddress" => $address,
                    "customerCity"    => $city,
                    "customerPinCode" => "$addressObject->zip",
                    "modeType"        => "Air",
                    "customerContact" => "8369180640",
                    "orderDate"       => Carbon::now()->toDateString(),
                    "orderType"       => "prepaid",
                    "totalValue"      => $orderToShip[ 'total' ],
                    "packageName"     => $orderToShip[ 'product_info' ],
                    "quantity"        => $orderToShip[ 'total_products' ],
                    "categoryName"    => "Eye Wears",
                    "packageLength"   => "5.50",
                    "packageWidth"    => "10",
                    "packageHeight"   => "1.0",
                    "packageWeight"   => "0.5",
                    "sellerAddressId" => "942"
                ]
            ]
        ];

        $data_json = json_encode($data);
        $header = array(
            "x-appid: $appID",
            "x-sellerid:6878",
            "x-timestamp: $timestamp",
            "Authorization:" . $authToken,
            "Content-Type: application/json",
            "Content-Length: " . strlen($data_json)
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/order');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);

        return $response;

    }

    /**
     * @return array
     */
    protected function shypLiteAuth()
    {
        $email = "Theopticalstudio.in@gmail.com";
        $password = "tos28247040";

        $timestamp = time();
        $appID = 1222;
        $key = '0Qi2SIbfoCU=';
        $secret = '9OxUhFFWVGmRmSw7mhZrF79xvNVnGhTzhNLrS9xeIKCEqcJJmXrG0F7KPeAuFSvyW6P4neFMHy0zOSoQGSlM0Q==';

        $sign = "key:" . $key . "id:" . $appID . ":timestamp:" . $timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));

        return array($email, $password, $timestamp, $appID, $authtoken);
    }
}