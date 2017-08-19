<?php

namespace App\Http\Controllers\Front;

use App\Addresses\Address;
use App\Couriers\Courier;
use App\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Customers\Customer;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Orders\Order;
use App\OrderStatuses\OrderStatus;
use App\PaymentMethods\PaymentMethod;

class AccountsController extends Controller
{
    private $customerRepo;
    private $courierRepo;

    public function __construct(
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepo = $customerRepository;
        $this->courierRepo = $courierRepository;
    }

    public function index()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $order = $customer->orders;
        $order->map(function (Order $order) {
            $order->courier = Courier::find($order->courier_id);
            $order->customer = Customer::find($order->customer_id);
            $order->address = Address::find($order->address_id);
            $order->status = OrderStatus::find($order->order_status_id);
            $order->payment = PaymentMethod::find($order->payment_method_id);
            return $order;
        });

        return view('front.accounts', [
            'customer' => $customer,
            'orders' => $order
        ]);
    }
}