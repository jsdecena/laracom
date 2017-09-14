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
                    <div class="pull-right">
                        <!-- search form -->
                        <form action="{{route('admin.orders.index')}}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search..." value="{!! request()->input('q') !!}">
                                <span class="input-group-btn">
                                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> Search
                                </button>
                              </span>
                            </div>
                        </form>
                        <!-- /.search form -->
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="col-md-3">Date</td>
                                <td class="col-md-3">Customer</td>
                                <td class="col-md-2">Courier</td>
                                <td class="col-md-2">Total</td>
                                <td class="col-md-2">Status</td>
                            </tr>
                        </tbody>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a title="Show order" href="{{ route('admin.orders.show', $order->id) }}">{{ date('M d, Y h:i a', strtotime($order->created_at)) }}</a></td>
                                <td>{{$order->customer->name}}</td>
                                <td>{{ $order->courier->name }}</td>
                                <td>
                                    <span class="label @if($order->total != $order->total_paid) label-danger @else label-success @endif">Php {{ $order->total }}</span>
                                </td>
                                <td><p class="text-center" style="color: #ffffff; background-color: {{ $order->status->color }}">{{ $order->status->name }}</p></td>
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