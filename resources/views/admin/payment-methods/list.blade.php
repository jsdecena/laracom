@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$paymentMethods->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2> <i class="fa fa-flask"></i> Payment Methods</h2>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="col-md-3">Name</td>
                            <td class="col-md-3">Color</td>
                            <td class="col-md-3">Status</td>
                            <td class="col-md-3">Actions</td>
                        </tr>
                        </tbody>
                        <tbody>
                        @foreach ($paymentMethods as $paymentMethod)
                            <tr>
                                <td>{{ $paymentMethod->name }}</td>
                                <td>{{ $paymentMethod->description }}</td>
                                <td>@include('layouts.status', ['status' => $paymentMethod->status])</td>
                                <td>
                                    <form action="{{ route('payment-methods.destroy', $paymentMethod->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('payment-methods.edit', $paymentMethod->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
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
