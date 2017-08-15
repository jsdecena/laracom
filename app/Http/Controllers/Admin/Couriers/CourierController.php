<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Countries\Repositories\CountryRepository;
use App\Couriers\Repositories\CourierRepository;
use App\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Couriers\Requests\CreateCourierRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourierController extends Controller
{
    private $courierRepo;

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
        return redirect()->route('couriers.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $courier = $this->courierRepo->findCourierById($id);

        $update = new CourierRepository($courier);
        $update->updateCourier($request->all());

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('couriers.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->courierRepo->delete($id);
        } catch (QueryException $e) {
            request()->session()->flash('error', 'Sorry, we cannot delete this courier since an order used this before.');
            return redirect()->route('couriers.index');
        }

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('couriers.index');
    }
}
