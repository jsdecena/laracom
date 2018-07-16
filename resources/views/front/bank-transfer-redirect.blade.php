@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="col-md-12">
                <form action="{{ route('bank-transfer.store') }}" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <h3>Review</h3>
                        <hr>
                        <ul class="list-unstyled">
                            <li>Items: {{ config('cart.currency_symbol') }} {{ $subtotal }}</li>
                            <li>Tax: {{ config('cart.currency_symbol') }} {{ $tax }}</li>
                            <li>Shipping Fee: {{ config('cart.currency_symbol') }} {{ $shipping }}</li>
                            <li>Total: {{ config('cart.currency_symbol') }} {{ $total }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                            <h3>{{ config('bank-transfer.bank_name') }}</h3>
                            <hr>
                            <p>{{ config('bank-transfer.account_type') }}</p>
                            <p>{{ config('bank-transfer.account_name') }}</p>
                            <p>{{ config('bank-transfer.account_number') }}</p>
                            <p>{{ config('bank-transfer.bank_swift_code') }}</p>
                            <p><small class="text-warning text">* {{ config('bank-transfer.note') }}</small></p>
                            <hr>
                            <div class="btn-group">
                                <a href="{{ route('checkout.index') }}" class="btn btn-default">Back</a>
                                <button onclick="return confirm('Are you sure?')" class="btn btn-primary">Pay now with Bank Transfer</button>
                                <input type="hidden" id="billing_address" name="billing_address" value="{{ $billingAddress }}">
                                <input type="hidden" name="shipment_obj_id" value="{{ $shipmentObjId }}">
                                <input type="hidden" name="rate" value="{{ $rateObjectId }}">
                                @if(request()->has('courier'))
                                    <input type="hidden" name="courier" value="{{ request()->input('courier') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection