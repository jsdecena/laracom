@extends('layouts.front.app')

@section('content')
        <div class="container product-in-cart-list">
            @if(!empty($products) && !collect($products)->isEmpty())
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
                                <th class="col-md-2">Cover</th>
                                <th class="col-md-3">Name</th>
                                <th class="col-md-3">Description</th>
                                <th class="col-md-1">Quantity</th>
                                <th class="col-md-1"></th>
                                <th class="col-md-2">Price</th>
                            </thead>
                            <tfoot>
                            <tr>
                                <td class="bg-warning">Subtotal</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning">{{config('cart.currency')}} {{ $subtotal }}</td>
                            </tr>
                            @if(isset($shippingFee) && $shippingFee != 0)
                            <tr>
                                <td class="bg-warning">Shipping</td>
                                <td class="bg-warning"></td>
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
                                <td class="bg-warning"></td>
                                <td class="bg-warning">{{config('cart.currency')}} {{ number_format($tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="bg-success">Total</td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success">{{config('cart.currency')}} {{ $total }}</td>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('front.get.product', [$product->slug]) }}" class="hover-border">
                                            @if(isset($product->cover))
                                                <img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}" class="img-responsive img-thumbnail">
                                            @else
                                                <img src="https://placehold.it/120x120" alt="" class="img-responsive img-thumbnail">
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $product->rowId) }}" class="form-inline" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="put">
                                            <div class="form-group">
                                                <input type="text" name="quantity" value="{{ $product->qty }}" class="form-control" />
                                            </div>
                                            <button class="btn btn-default btn-block">Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.destroy', $product->rowId) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                    <td>{{config('cart.currency')}} {{ number_format($product->price, 2) }}</td>
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