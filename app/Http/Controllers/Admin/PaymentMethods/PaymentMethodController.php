<?php

namespace App\Http\Controllers\Admin\PaymentMethods;

use App\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\PaymentMethods\Repositories\PaymentMethodRepository;
use App\PaymentMethods\Requests\CreatePaymentMethodRequest;
use App\PaymentMethods\Requests\UpdatePaymentMethodRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepo;


    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepo = $paymentMethodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payment-methods.list', [
            'paymentMethods' => $this->paymentMethodRepo->listPaymentMethods('name', 'asc')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentMethodRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePaymentMethodRequest $request)
    {
        $this->paymentMethodRepo->createPaymentMethod($request->all());

        $request->session()->flash('message', 'Create successful');
        return redirect()->route('admin.payment-methods.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('admin.payment-methods.edit', [
            'paymentMethod' => $this->paymentMethodRepo->findPaymentMethodById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePaymentMethodRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        $paymentMethod = $this->paymentMethodRepo->findPaymentMethodById($id);

        $update = new PaymentMethodRepository($paymentMethod);
        $update->updatePaymentMethod($request->all());

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.payment-methods.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->paymentMethodRepo->delete($id);
        } catch (QueryException $e) {
            request()->session()->flash('error', 'Sorry, we cannot delete this payment method since an order used this before.');
            return redirect()->route('admin.payment-methods.index');
        }

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.payment-methods.index');
    }
}
