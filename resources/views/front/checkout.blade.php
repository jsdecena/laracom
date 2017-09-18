@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        @if($products)
            <form action="{{ route('checkout.store') }}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                            <li><a href="#">Category</a></li>
                            <li class="active">Product</li>
                        </ol>
                    </div>
                    <div class="col-md-12 content">
                        <div class="box-body">
                            @include('layouts.errors-and-messages')
                        </div>
                        <h3><i class="fa fa-cart-plus"></i> Shopping Cart</h3>
                        <table class="table table-striped">
                            <thead>
                                <th class="text-center col-md-2">Cover</th>
                                <th class="text-center col-md-3">Name</th>
                                <th class="text-center col-md-3">Description</th>
                                <th class="text-center col-md-2">Quantity</th>
                                <th class="text-center col-md-2">Price</th>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr class="text-center">
                                    <td>
                                        <a href="{{ route('front.get.product', $product->product->slug) }}" class="hover-border">
                                            @if(isset($product->product->cover))
                                                <img src="{{ asset("uploads/$product->cover") }}" alt="{{ $product->name }}" class="img-responsive img-thumbnail">
                                            @else
                                                <img src="https://placehold.it/120x120" alt="" class="img-responsive img-thumbnail">
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->product->description }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>Php {{ number_format($product->product->price, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tbody>
                            <tr>
                                <td class="bg-warning">Subtotal</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="text-center bg-warning">Php {{ $subtotal }}</td>
                            </tr>
                            <tr>
                                <td class="bg-warning">Tax</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="text-center bg-warning">Php {{ number_format($tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="bg-success">Total</td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="text-center bg-success">Php {{ $total }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        @if(count($addresses) > 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-map-marker"></i> Delivery address</h2>
                                    <table class="table table-striped">
                                        <thead>
                                            <th class="col-md-1">Alias</th>
                                            <th class="col-md-3">Address</th>
                                            <th class="col-md-2">City</th>
                                            <th class="col-md-2">Province</th>
                                            <th class="col-md-2">Country</th>
                                            <th class="col-md-1">Zip Code</th>
                                            <th class="col-md-1">Choose</th>
                                        </thead>
                                        <tbody>
                                        @foreach($addresses as $address)
                                            <tr>
                                                <td>{{ $address->alias }}</td>
                                                <td>{{ $address->address_1 }} <br /> {{ $address->address_2 }}</td>
                                                <td>{{ $address->city->name }}</td>
                                                <td>{{ $address->province->name }}</td>
                                                <td>{{ $address->country->name }}</td>
                                                <td>{{ $address->zip }}</td>
                                                <td>
                                                    <label class="col-md-2 col-md-offset-1">
                                                        <input type="radio" class="form-control" name="address" @if(old('address') == $address->id) checked="checked"  @endif value="{{ $address->id }}">
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h2> <i class="fa fa-truck"></i> Courier</h2>
                                    @if(!$couriers->isEmpty())
                                        <table class="table">
                                        <thead>
                                            <th class="col-md-4">Name</th>
                                            <th class="col-md-4">Description</th>
                                            <th class="col-md-4">Choose courier</th>
                                        </thead>
                                        <tbody>
                                            @foreach($couriers as $courier)
                                            <tr>
                                                <td>{{ $courier->name }}</td>
                                                <td>{{ $courier->description }}</td>
                                                <td>
                                                    <label class="col-md-2 col-md-offset-3">
                                                        <input type="radio" class="form-control" name="courier" value="{{ $courier->id }}" @if(old('courier') == $courier->id) checked="checked"  @endif>
                                                    </label>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <p class="alert alert-danger">No courier set</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h2> <i class="fa fa-money"></i> Payment Method</h2>
                                    @if($payments)
                                        <table class="table">
                                            <thead>
                                            <th class="col-md-4">Name</th>
                                            <th class="col-md-4">Description</th>
                                            <th class="col-md-4">Choose payment</th>
                                            </thead>
                                            <tbody>
                                            @foreach($payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->name }}</td>
                                                    <td>{{ $payment->description }}</td>
                                                    <td>
                                                        <label class="col-md-2 col-md-offset-3">
                                                            <input type="radio" class="form-control" name="payment" value="{{ $payment->id }}" @if(old('payment') == $payment->id) checked="checked"  @endif>
                                                        </label>
                                                    </td>
                                                </tr>
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
                @if(count($addresses) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('cart.index') }}" class="btn btn-default"> <i class="fa fa-shopping-basket"></i> Review cart</a>
                                <button class="btn btn-primary"> <i class="fa fa-check"></i> Checkout now</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </form>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-warning">No products in cart yet. <a href="{{ route('home') }}">Show now!</a></p>
                </div>
            </div>
        @endif
    </div>
@endsection