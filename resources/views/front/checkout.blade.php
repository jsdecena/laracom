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
                                    <h3><i class="fa fa-map-marker text-success"></i> Choose delivery address</h3>
                                    <table class="table table-striped">
                                        <thead>
                                            <th class="col-md-4">Alias</th>
                                            <th class="col-md-4">Address</th>
                                            <th class="col-md-4">Choose Address</th>
                                        </thead>
                                        <tbody>
                                        @foreach($addresses as $address)
                                            <tr>
                                                <td>{{ $address->alias }}</td>
                                                <td>
                                                    {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                    {{ $address->city->name }} {{ $address->province->name }} <br />
                                                    {{ $address->country->name }} {{ $address->zip }}
                                                </td>
                                                <td>
                                                    <label class="col-md-2 col-md-offset-3">
                                                        <input type="radio" class="form-control" name="billing_address" @if($selectedAddress == $address->id) checked="checked"  @endif value="{{ $address->id }}">
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
                                    <h3> <i class="fa fa-truck text-success"></i> Choose courier</h3>
                                    @if(!$couriers->isEmpty())
                                        <table class="table">
                                        <thead>
                                            <th class="col-md-4">Name</th>
                                            <th class="col-md-4">Cost</th>
                                            <th class="col-md-4">Choose courier</th>
                                        </thead>
                                        <tbody>
                                            @foreach($couriers as $courier)
                                            <tr>
                                                <td>{{ $courier->name }}</td>
                                                <td>{{config('cart.currency')}} {{ $courier->cost }}</td>
                                                <td>
                                                    <label class="col-md-2 col-md-offset-3">
                                                        <input type="radio" class="form-control" name="courier" value="{{ $courier->id }}" @if($selectedCourier == $courier->id) checked="checked"  @endif>
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3> <i class="fa fa-money text-success"></i> Choose payment method</h3>
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
                                                            <input type="radio" class="form-control" name="payment" value="{{ $payment->id }}" @if($selectedPayment == $payment->id) checked="checked"  @endif>
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
                        <hr>
                        <h3><i class="fa fa-cart-plus text-success"></i> Your Total</h3>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td class="bg-warning">Subtotal</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="text-center bg-warning">{{config('cart.currency')}} {{ $subtotal }}</td>
                            </tr>
                            <tr id="shippingRow" @if($shipping == 0)style="display: none"@endif>
                                <td class="bg-warning">Shipping</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="text-center bg-warning">{{config('cart.currency')}} <span id="shippingFee"> {{ $shipping }}</span></td>
                            </tr>
                            <tr>
                                <td class="bg-warning">Tax</td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="bg-warning"></td>
                                <td class="text-center bg-warning">{{config('cart.currency')}} {{ $tax }}</td>
                            </tr>
                            <tr>
                                <td class="bg-success">Total</td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="bg-success"></td>
                                <td class="text-center bg-success">{{config('cart.currency')}} <span id="cartTotal">{{ $total }}</span></td>
                            </tr>
                            </tbody>
                        </table>
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

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            // Payment options
            $('input[name="payment"]').on('change', function () {
                $.ajax({
                    type: 'post',
                    url: '/set-payment',
                    data: { paymentId: $(this).val(), _token: $('input[name="_token"]').val()},
                    success: function(data){
                        //
                    }
                });
            });

            // Addresses
            $('input[name="address"]').on('change', function () {
                $.ajax({
                    type: 'post',
                    url: '/set-address',
                    data: { addressId: $(this).val(), _token: $('input[name="_token"]').val()},
                    success: function(data){
                        //
                    }
                });
            });

            // Couriers
            $('input[name="courier"]').on('change', function () {
                $.ajax({
                    type: 'post',
                    url: '/set-courier',
                    data: { courierId: $(this).val(), _token: $('input[name="_token"]').val()},
                    success: function(data){
                        console.log(data);
                        $(data.courier).each(function (idx, shipping) {
                            $('#shippingFee').html(shipping.cost);
                            if (shipping.cost != 0) {
                                $('#shippingRow').fadeIn();
                            } else {
                                $('#shippingRow').fadeOut();
                            }
                        });
                        $('#cartTotal').html(data.cartTotal);
                    }
                });
            });
        });
    </script>
@endsection