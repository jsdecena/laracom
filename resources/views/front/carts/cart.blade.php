@extends('layouts.front.app')

@section('content')
        <div class="container product-in-cart-list">
            @if(!$cartItems->isEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
                            <li class="active">Cart</li>
                        </ol>
                    </div>
                    <div class="col-md-12 content">
                        <div class="box-body">
                            @include('layouts.errors-and-messages')
                        </div>
                        <h3><i class="fa fa-cart-plus"></i> Shopping Cart</h3>
                        <table class="table table-striped">
                            <thead>
                                <th class="col-md-2 col-lg-2">Cover</th>
                                <th class="col-md-2 col-lg-5">Name</th>
                                <th class="col-md-2 col-lg-2">Quantity</th>
                                <th class="col-md-2 col-lg-1"></th>
                                <th class="col-md-2 col-lg-2">Price</th>
                            </thead>
                            <tfoot>
                            <tr>
                                <td class="bg-warning">Subtotal</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning">{{config('cart.currency')}} {{ number_format($subtotal, 2, '.', ',') }}</td>
                            </tr>
                            @if(isset($shippingFee) && $shippingFee != 0)
                            <tr>
                                <td class="bg-warning">Shipping</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning">{{config('cart.currency')}} {{ $shippingFee }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="bg-warning">Tax</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning">{{config('cart.currency')}} {{ number_format($tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="bg-success">Total</td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success">{{config('cart.currency')}} {{ number_format($total, 2, '.', ',') }}</td>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($cartItems as $cartItem)
                                <tr>
                                    <td>
                                        <a href="{{ route('front.get.product', [$cartItem->product->slug]) }}" class="hover-border">
                                            @if(isset($cartItem->cover))
                                                <img src="{{$cartItem->cover}}" alt="{{ $cartItem->name }}" class="img-responsive img-thumbnail">
                                            @else
                                                <img src="https://placehold.it/120x120" alt="" class="img-responsive img-thumbnail">
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <h3>{{ $cartItem->name }}</h3>
                                        @if($cartItem->options->has('combination'))
                                            @foreach($cartItem->options->combination as $option)
                                                <small class="label label-primary">{{$option['value']}}</small>
                                            @endforeach
                                        @endif
                                        <div class="product-description">
                                            {!! $cartItem->product->description !!}
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.update', $cartItem->rowId) }}" class="form-inline" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="put">
                                            <div class="input-group">
                                                <input type="text" name="quantity" value="{{ $cartItem->qty }}" class="form-control" />
                                                <span class="input-group-btn"><button class="btn btn-default">Update</button></span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                    <td>{{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <a href="{{ route('home') }}" class="btn btn-default">Continue shopping</a>
                                    <a href="{{ route('checkout.index') }}" class="btn btn-primary">Go to checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <p class="alert alert-warning">No products in cart yet. <a href="{{ route('home') }}">Shop now!</a></p>
                    </div>
                </div>
            @endif
        </div>
@endsection
@section('css')
    <style type="text/css">
        .product-description {
            padding: 10px 0;
        }
        .product-description p {
            line-height: 18px;
            font-size: 14px;
        }
    </style>
@endsection