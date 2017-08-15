@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($addresses)
            <div class="box">
                <div class="box-body">
                    <h2>Addresses</h2>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="col-md-1">Alias</td>
                            <td class="col-md-2">Address 1</td>
                            <td class="col-md-1">Country</td>
                            <td class="col-md-1">Province</td>
                            <td class="col-md-1">City</td>
                            <td class="col-md-2">Customer</td>
                            <td class="col-md-1">Status</td>
                            <td class="col-md-3">Actions</td>
                        </tr>
                        </tbody>
                        <tbody>
                        @foreach ($addresses as $address)
                            <tr>
                                <td>{{ $address->alias }}</td>
                                <td>{{ $address->address_1 }}</td>
                                <td>{{ $address->country->name }}</td>
                                <td>{{ $address->province->name }}</td>
                                <td>{{ $address->city->name }}</td>
                                <td><a href="{{ route('customers.show', $address->customer->id) }}">{{ $address->customer->name }}</a></td>
                                <td>@include('layouts.status', ['status' => $address->status])</td>
                                <td>
                                    <form action="{{ route('addresses.destroy', $address->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('addresses.show', $address->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                            <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $addresses->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection