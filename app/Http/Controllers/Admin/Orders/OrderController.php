<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Addresses\Address;
use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Couriers\Courier;
use App\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Customers\Customer;
use App\Orders\Order;
use App\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\OrderStatuses\OrderStatus;
use App\PaymentMethods\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $orderRepo;
    private $courierRepo;
    private $addressRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository
    )
    {
        $this->orderRepo = $orderRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->orderRepo->listOrders('created_at', 'desc');
        $list->map(function (Order $order) {
            $order->courier = Courier::find($order->courier_id);
            $order->customer = Customer::find($order->customer_id);
            $order->address = Address::find($order->address_id);
            $order->status = OrderStatus::find($order->order_status_id);
            $order->payment = PaymentMethod::find($order->payment_method_id);
            return $order;
        });

        $orders = $this->orderRepo->paginateArrayResults($list->all(), 25);

        return view('admin.orders.list', ['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        $items = $this->orderRepo->findProducts($order);
        return view('admin.orders.show', [
            'order' => $order,
            'items' => $items
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
