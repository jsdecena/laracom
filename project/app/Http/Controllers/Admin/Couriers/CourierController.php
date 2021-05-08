<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Couriers\Requests\CreateCourierRequest;
use App\Shop\Couriers\Requests\UpdateCourierRequest;
use App\Http\Controllers\Controller;

class CourierController extends Controller
{
    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * CourierController constructor.
     * @param CourierRepositoryInterface $courierRepository
     */
    public function __construct(CourierRepositoryInterface $courierRepository)
    {
        $this->courierRepo = $courierRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.couriers.list', ['couriers' => $this->courierRepo->listCouriers('name', 'asc')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.couriers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCourierRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCourierRequest $request)
    {
        $this->courierRepo->createCourier($request->all());

        $request->session()->flash('message', 'Create successful');
        return redirect()->route('admin.couriers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('admin.couriers.edit', ['courier' => $this->courierRepo->findCourierById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCourierRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourierRequest $request, $id)
    {
        $courier = $this->courierRepo->findCourierById($id);

        $update = new CourierRepository($courier);
        $update->updateCourier($request->all());

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.couriers.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $courier = $this->courierRepo->findCourierById($id);

        $courierRepo = new CourierRepository($courier);
        $courierRepo->delete();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.couriers.index');
    }
}
