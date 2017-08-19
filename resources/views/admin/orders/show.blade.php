@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <h2>
                    <a href="{{ route('admin.customers.show', $customer->id) }}">{{$customer->name}}</a> <br />
                    <small>{{$customer->email}}</small>
                </h2>
            </div>
        </div>

        @if($order)
            @if($order->total != $order->total_paid)
                <p class="alert alert-danger">
                    Ooops, there is discrepancy in the total amount of the order and the amount paid. <br />
                    Total order amount: <strong>Php {{ $order->total }}</strong> <br>
                    Total amount paid <strong>Php {{ $order->total_paid }}</strong>
                </p>

            @endif
            <div class="box">
                @if(!$items->isEmpty())
                    <div class="box-body">
                        <h2> <i class="fa fa-gift"></i> Items</h2>
                        <table class="table">
                            <thead>
                            <th class="col-md-2">SKU</th>
                            <th class="col-md-2">Name</th>
                            <th class="col-md-2">Description</th>
                            <th class="col-md-2">Quantity</th>
                            <th class="col-md-2">Price</th>
                            <th class="col-md-2">Status</th>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>@include('layouts.status', ['status' => $item->status])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="box-body">
                    <h2> <i class="fa fa-shopping-bag"></i> Order Information</h2>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="col-md-2">Date</td>
                            <td class="col-md-2">Customer</td>
                            <td class="col-md-2">Courier</td>
                            <td class="col-md-2">Payment</td>
                            <td class="col-md-4">Status</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td>{{ date('M d, Y h:i a', strtotime($order['created_at'])) }}</td>
                            <td><a href="{{ route('admin.customers.show', $order['customer']['id']) }}">{{ $order['customer']['name'] }}</a></td>
                            <td>{{ $order['courier']['name'] }}</td>
                            <td>{{ $order['paymentMethod']['name'] }}</td>
                            <td>{{ $order['orderStatus']['name'] }}</td>
                        </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="bg-warning">Subtotal</td>
                                <td class="bg-warning">{{ $order['total_products'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="bg-warning">Tax</td>
                                <td class="bg-warning">{{ $order['tax'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="bg-warning">Discount</td>
                                <td class="bg-warning">{{ $order['discounts'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="bg-success text-bold">Order Total</td>
                                <td class="bg-success text-bold">{{ $order['total'] }}</td>
                            </tr>
                            @if($order['total_paid'] != $order['total'])
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="bg-danger text-bold">Total paid</td>
                                    <td class="bg-danger text-bold">{{ $order['total_paid'] }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h2> <i class="fa fa-truck"></i> Courier</h2>
                            <table class="table">
                                <thead>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Link</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $order->courier->name }}</td>
                                    <td>{{ $order->courier->description }}</td>
                                    <td>{{ $order->courier->url }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h2> <i class="fa fa-map-marker"></i> Address</h2>
                            <table class="table">
                                <thead>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>City</th>
                                    <th>Province</th>
                                    <th>Zip</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $order->address->address_1 }}</td>
                                    <td>{{ $order->address->address_2 }}</td>
                                    <td>{{ $order->address->city->name }}</td>
                                    <td>{{ $order->address->province->name }}</td>
                                    <td>{{ $order->address->zip }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
            <div class="box-footer">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-default">Back</a>
            </div>
        @endif

    </section>
    <!-- /.content -->
@endsection