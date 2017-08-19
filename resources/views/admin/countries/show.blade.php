@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="col-md-2">Name</td>
                        <td class="col-md-2">ISO</td>
                        <td class="col-md-2">ISO-3</td>
                        <td class="col-md-2">Numcode</td>
                        <td class="col-md-2">Phone Code</td>
                        <td class="col-md-2">Status</td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>{{ $country->name }}</td>
                        <td>{{ $country->iso }}</td>
                        <td>{{ $country->iso3 }}</td>
                        <td>{{ $country->numcode }}</td>
                        <td>{{ $country->phonecode }}</td>
                        <td>@include('layouts.status', ['status' => $country->status])</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-body">
                @include('admin.shared.provinces', ['country' => $country->id])
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.countries.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
