@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            <a href="{{ route('admin.customers.show', $customer->id) }}">{{$customer->name}}</a> <br />
                            <small>{{$customer->email}}</small> <br />
                            <small>reference: <strong>{{$order->reference}}</strong></small>
                        </h2>
                    </div>
                    <div class="col-md-3 col-md-offset-3">
                        <h2><a href="{{route('admin.orders.invoice.generate', $order['id'])}}" class="btn btn-primary btn-block">Download Invoice</a></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <h4> <i class="fa fa-shopping-bag"></i> Order Information</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="col-md-3">Date</td>
                            <td class="col-md-3">Customer</td>
                            <td class="col-md-3">Payment</td>
                            <td class="col-md-3">Status</td>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ date('M d, Y h:i a', strtotime($order['created_at'])) }}</td>
                        <td><a href="{{ route('admin.customers.show', $customer->id) }}">{{ $customer->name }}</a></td>
                        <td><strong>{{ $order['payment'] }}</strong></td>
                        <td>
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <label for="order_status_id" class="hidden">Update status</label>
                                <input type="text" name="total_paid" class="form-control" placeholder="Total paid" style="margin-bottom: 5px; display: none" value="{{ old('total_paid') ?? $order->total_paid }}" />
                                <div class="input-group">
                                    <select name="order_status_id" id="order_status_id" class="form-control select2">
                                        @foreach($statuses as $status)
                                            <option @if($currentStatus->id == $status->id) selected="selected" @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn"><button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-primary">Update</button></span>
                                </div>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-warning">Subtotal</td>
                        <td class="bg-warning">{{ $order['total_products'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-warning">Tax</td>
                        <td class="bg-warning">{{ $order['tax'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-warning">Discount</td>
                        <td class="bg-warning">{{ $order['discounts'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-success text-bold">Order Total</td>
                        <td class="bg-success text-bold">{{ $order['total'] }}</td>
                    </tr>
                    @if($order['total_paid'] != $order['total'])
                        <tr>
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
        </div>
        @if($order)
            @if($order->total != $order->total_paid)
                <p class="alert alert-danger">
                    Ooops, there is discrepancy in the total amount of the order and the amount paid. <br />
                    Total order amount: <strong>{{ config('cart.currency') }} {{ $order->total }}</strong> <br>
                    Total amount paid <strong>{{ config('cart.currency') }} {{ $order->total_paid }}</strong>
                </p>

            @endif
            <div class="box">
                @if(!$items->isEmpty())
                    <div class="box-body">
                        <h4> <i class="fa fa-gift"></i> Items</h4>
                        <table class="table">
                            <thead>
                            <th class="col-md-2">SKU</th>
                            <th class="col-md-2">Name</th>
                            <th class="col-md-2">Description</th>
                            <th class="col-md-2">Quantity</th>
                            <th class="col-md-2">Price</th>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! $item->description !!}</td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td>{{ $item->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4> <i class="fa fa-truck"></i> Courier</h4>
                            <table class="table">
                                <thead>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-4">Description</th>
                                    <th class="col-md-5">Link</th>
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
                            <h4> <i class="fa fa-map-marker"></i> Address</h4>
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
                                    <td>
                                        @if(isset($order->address->city))
                                            {{ $order->address->city->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($order->address->province))
                                            {{ $order->address->province->name }}
                                        @endif
                                    </td>
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
                <div class="btn-group">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-default">Back</a>
                </div>
            </div>
        @endif

    </section>
    <!-- /.content -->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            let osElement = $('#order_status_id');
            osElement.change(function () {
                if (+$(this).val() === 1) {
                    $('input[name="total_paid"]').fadeIn();
                } else {
                    $('input[name="total_paid"]').fadeOut();
                }
            });
        })
    </script>
@endsection