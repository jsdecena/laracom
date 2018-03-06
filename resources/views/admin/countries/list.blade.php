@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($countries)
            <div class="box">
                <div class="box-body">
                    <h2>Countries</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-2">Name</td>
                                <td class="col-md-1">ISO</td>
                                <td class="col-md-2">ISO-3</td>
                                <td class="col-md-1">Numcode</td>
                                <td class="col-md-1">Phone Code</td>
                                <td class="col-md-1">Status</td>
                                <td class="col-md-4">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->iso }}</td>
                                <td>{{ $country->iso3 }}</td>
                                <td>{{ $country->numcode }}</td>
                                <td>{{ $country->phonecode }}</td>
                                <td>@include('layouts.status', ['status' => $country->status])</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.countries.show', $country->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                        <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $countries->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
