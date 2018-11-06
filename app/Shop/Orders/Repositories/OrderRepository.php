<?php

namespace App\Shop\Orders\Repositories;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Events\OrderCreateEvent;
use App\Mail\sendEmailNotificationToAdminMailable;
use App\Mail\SendOrderToCustomerMailable;
use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\Shop\Orders\Exceptions\OrderNotFoundException;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Transformers\OrderTransformable;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    use OrderTransformable;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->model = $order;
    }

    /**
     * Create the order
     *
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function createOrder(array $params) : Order
    {
        try {

            $order = $this->create($params);

            $orderRepo = new OrderRepository($order);
            $orderRepo->buildOrderDetails(Cart::content());

            event(new OrderCreateEvent($order));

            return $order;
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * @param array $params
     *
     * @return bool
     * @throws OrderInvalidArgumentException
     */
    public function updateOrder(array $params) : bool
    {
        try {
            return $this->update($params);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function findOrderById(int $id) : Order
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderNotFoundException($e);
        }
    }


    /**
     * Return all the orders
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function findProducts(Order $order) : Collection
    {
        return $order->products;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param array $data
     */
    public function associateProduct(Product $product, int $quantity = 1, array $data = [])
    {
        $this->model->products()->attach($product, [
            'quantity' => $quantity,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_description' => $product->description,
            'product_price' => $product->price,
            'product_attribute_id' => isset($data['product_attribute_id']) ? $data['product_attribute_id']: null,
        ]);
        $product->quantity = ($product->quantity - $quantity);
        $product->save();
    }

    /**
     * Send email to customer
     */
    public function sendEmailToCustomer()
    {
        Mail::to($this->model->customer)
            ->send(new SendOrderToCustomerMailable($this->findOrderById($this->model->id)));
    }

    /**
     * Send email notification to the admin
     */
    public function sendEmailNotificationToAdmin()
    {
        $employeeRepo = new EmployeeRepository(new Employee);
        $employee = $employeeRepo->findEmployeeById(1);

        Mail::to($employee)
            ->send(new sendEmailNotificationToAdminMailable($this->findOrderById($this->model->id)));
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchOrder(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchForOrder($text)->get();
        } else {
            return $this->listOrders();
        }
    }

    /**
     * @return Order
     */
    public function transform()
    {
        return $this->transformOrder($this->model);
    }

    /**
     * @return Collection
     */
    public function listOrderedProducts() : Collection
    {
        return $this->model->products->map(function (Product $product) {
            $product->name = $product->pivot->product_name;
            $product->sku = $product->pivot->product_sku;
            $product->description = $product->pivot->product_description;
            $product->price = $product->pivot->product_price;
            $product->quantity = $product->pivot->quantity;
            $product->product_attribute_id = $product->pivot->product_attribute_id;
            return $product;
        });
    }

    /**
     * @param Collection $items
     */
    public function buildOrderDetails(Collection $items)
    {
        $items->each(function ($item) {
            $productRepo = new ProductRepository(new Product);
            $product = $productRepo->find($item->id);
            if ($item->options->has('product_attribute_id')) {
                $this->associateProduct($product, $item->qty, [
                    'product_attribute_id' => $item->options->product_attribute_id
                ]);
            } else {
                $this->associateProduct($product, $item->qty);
            }
        });
    }
}
