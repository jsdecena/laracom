@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <h2>Attributes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <td>Attribute name</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $attribute->name }}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection