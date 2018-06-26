@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        @if(!$products->isEmpty())
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Shopping Cart</li>
                    </ol>
                </div>
                <div class="col-md-12 content">
                    <div class="box-body">
                        @include('layouts.errors-and-messages')
                    </div>
                    @if(count($addresses) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                @include('front.products.product-list-table', compact('products'))
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Alias</th>
                                        <th>Address</th>
                                        <th>Billing Address</th>
                                        <th>Delivery Address</th>
                                    </thead>
                                    <tbody>
                                        @foreach($addresses as $key => $address)
                                            <tr>
                                                <td>{{ $address->alias }}</td>
                                                <td>
                                                    {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                    @if(!is_null($address->province) || !is_null($address->city))
                                                        {{ $address->city->name }} {{ $address->province->name }} <br />
                                                    @endif
                                                    {{ $address->country->name }} {{ $address->zip }}
                                                </td>
                                                <td>
                                                    <label class="col-md-6 col-md-offset-3">
                                                    <input
                                                                type="radio"
                                                                value="{{ $address->id }}"
                                                                name="billing_address"
                                                                @if(old('billing_address') == $address->id) checked="checked"  @endif>
                                                    </label>
                                                </td>
                                                <td>
                                                    @if($key === 0)
                                                        <label for="sameDeliveryAddress">
                                                            <input type="checkbox" id="sameDeliveryAddress" checked="checked"> Same as billing
                                                        </label>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody style="display: none" id="sameDeliveryAddressRow">
                                        @foreach($addresses as $key => $address)
                                            <tr>
                                                <td>{{ $address->alias }}</td>
                                                <td>
                                                    {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                    @if(!is_null($address->province) || !is_null($address->city))
                                                        {{ $address->city->name }} {{ $address->province->name }} <br />
                                                    @endif
                                                    {{ $address->country->name }} {{ $address->zip }}
                                                </td>
                                                <td></td>
                                                <td>
                                                    <label class="col-md-6 col-md-offset-3">
                                                        <input
                                                                type="radio"
                                                                value="{{ $address->id }}"
                                                                name="delivery_address"
                                                                @if(old('') == $address->id) checked="checked"  @endif>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($payments) && !empty($payments))
                                    <table class="table table-striped">
                                        <thead>
                                        <th class="col-md-4">Name</th>
                                        <th class="col-md-4">Description</th>
                                        <th class="col-md-4 text-right">Choose payment</th>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment)
                                            @include('layouts.front.payment-options', compact('payment', 'total'))
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="alert alert-danger">No payment method set</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="alert alert-danger"><a href="{{ route('customer.address.create', [$customer->id]) }}">No address found. You need to create an address first here.</a></p>
                    @endif
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-warning">No products in cart yet. <a href="{{ route('home') }}">Show now!</a></p>
                </div>
            </div>
        @endif
    </div>
@endsection