@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($orders)
            <div class="box">
                <div class="box-body">
                    <h2>Orders</h2>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="col-md-2">Date</td>
                                <td class="col-md-2">Customer</td>
                                <td class="col-md-2">Courier</td>
                                <td class="col-md-1">Total</td>
                                <td class="col-md-1">Status</td>
                                <td class="col-md-4">Actions</td>
                            </tr>
                        </tbody>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ date('M d, Y h:i a', strtotime($order['created_at'])) }}</td>
                                <td><a href="{{ route('customers.show', $order['customer']['id']) }}">{{ $order['customer']['name'] }}</a></td>
                                <td>{{ $order['courier']['name'] }}</td>
                                <td>
                                    <span class="label @if($order['total'] != $order['total_paid']) label-danger @else label-success @endif">Php {{ $order['total'] }}</span>
                                </td>
                                <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['orderStatus']['color'] }}">{{ $order['orderStatus']['name'] }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('orders.show', $order['id']) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ $orders->links() }}
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection