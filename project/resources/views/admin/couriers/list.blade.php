@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($couriers)
            <div class="box">
                <div class="box-body">
                    <h2> <i class="fa fa-truck"></i> Couriers</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-2">Name</td>
                                <td class="col-md-2">Description</td>
                                <td class="col-md-2">URL</td>
                                <td class="col-md-1">Is Free?</td>
                                <td class="col-md-1">Cost</td>
                                <td class="col-md-1">Status</td>
                                <td class="col-md-3">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($couriers as $courier)
                            <tr>
                                <td>{{ $courier->name }}</td>
                                <td>{{ str_limit($courier->description, 100, ' ...') }}</td>
                                <td>{{ $courier->url }}</td>
                                <td>
                                    @include('layouts.status', ['status' => $courier->is_free])
                                </td>
                                <td>
                                    {{config('cart.currency')}} {{ $courier->cost }}
                                </td>
                                <td>@include('layouts.status', ['status' => $courier->status])</td>
                                <td>
                                    <form action="{{ route('admin.couriers.destroy', $courier->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.couriers.edit', $courier->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection