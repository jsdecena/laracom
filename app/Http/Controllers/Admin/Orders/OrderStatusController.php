<?php

namespace App\Http\Controllers\Admin\Orders;

use App\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\OrderStatuses\Repositories\OrderStatusRepository;
use App\OrderStatuses\Requests\CreateOrderStatusRequest;
use App\OrderStatuses\Requests\UpdateOrderStatusRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusController extends Controller
{
    private $orderStatuses;


    public function __construct(OrderStatusRepositoryInterface $orderStatusRepository)
    {
        $this->orderStatuses = $orderStatusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order-statuses.list', ['orderStatuses' => $this->orderStatuses->listOrderStatuses()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderStatusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderStatusRequest $request)
    {
        $this->orderStatuses->createOrderStatus($request->all());
        $request->session()->flash('message', 'Create successful');
        return redirect()->route('admin.order-statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('admin.order-statuses.edit', ['orderStatus' => $this->orderStatuses->findOrderStatusById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderStatusRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderStatusRequest $request, int $id)
    {
        $orderStatus = $this->orderStatuses->findOrderStatusById($id);
        $update = new OrderStatusRepository($orderStatus);

        $update->updateOrderStatus($request->all());
        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.order-statuses.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $os = $this->orderStatuses->findOrderStatusById($id);

        try {
            $this->orderStatuses->deleteOrderStatus($os);
        } catch (QueryException $e) {
            request()->session()->flash('error', 'Ooops, there is an order that has this status so we cannot delete this. Sorry.');
            return redirect()->route('admin.order-statuses.index');
        }

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.order-statuses.index');
    }
}
