<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Couriers\Courier;
use App\Couriers\Repositories\CourierRepository;
use App\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Customers\Customer;
use App\Customers\Repositories\CustomerRepository;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Orders\Order;
use App\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\OrderStatuses\OrderStatus;
use App\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\OrderStatuses\Repositories\OrderStatusRepository;
use App\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $orderRepo;
    private $courierRepo;
    private $addressRepo;
    private $customerRepo;
    private $orderStatusRepo;
    private $paymentRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderStatusRepositoryInterface $orderStatusRepository,
        PaymentMethodRepositoryInterface $paymentMethodRepository
    )
    {
        $this->orderRepo = $orderRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->orderStatusRepo = $orderStatusRepository;
        $this->paymentRepo = $paymentMethodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->orderRepo->listOrders('created_at', 'desc');

        $courierRepo = new CourierRepository(new Courier());
        $customerRepo = new CustomerRepository(new Customer());
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus());

        $list->map(function (Order $order) use ($courierRepo, $customerRepo, $orderStatusRepo) {
            $order->courier = $courierRepo->findCourierById($order->courier_id);
            $order->customer = $customerRepo->findCustomerById($order->customer_id);
            $order->status = $orderStatusRepo->findOrderStatusById($order->order_status_id);
            return $order;
        });

        $orders = $this->orderRepo->paginateArrayResults($list->all(), 25);

        return view('admin.orders.list', ['orders' => $orders]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $order = $this->orderRepo->findOrderById($id);
        $order->courier = $this->courierRepo->findCourierById($order->courier_id);
        $order->address = $this->addressRepo->findAddressById($order->address_id);

        return view('admin.orders.show', [
            'order' => $order,
            'items' => $this->orderRepo->findProducts($order),
            'customer' => $this->customerRepo->findCustomerById($order->customer_id),
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById($order->order_status_id),
            'payment' => $this->paymentRepo->findPaymentMethodById($order->payment_method_id)
        ]);
    }

    /**
     * Generate order invoice
     *
     * @return mixed
     */
    public function generateInvoice()
    {
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('invoices.orders')->stream();
        return $pdf->stream();
    }
}
