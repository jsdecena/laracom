<?php

namespace App\Http\Controllers\Front;

use Laracommerce\Core\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use Laracommerce\Core\Customers\Repositories\CustomerRepository;
use Laracommerce\Core\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\Orders\Transformations\OrderTransformable;

class AccountsController extends Controller
{
    use OrderTransformable;

    private $customerRepo;
    private $courierRepo;

    public function __construct(
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepo = $customerRepository;
        $this->courierRepo = $courierRepository;
    }

    public function index()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);
        $orders = $customerRepo->findOrders();

        $orders->transform(function (Order $order) {
            return $this->transformOrder($order);
        });

        $addresses = $customerRepo->findAddresses();

        return view('front.accounts', [
            'customer' => $customer,
            'orders' => $this->customerRepo->paginateArrayResults($orders->toArray(), 3),
            'addresses' => $addresses
        ]);
    }
}
