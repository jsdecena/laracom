@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$permissions->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2>Permissions</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Display Name</td>
                                <td>Description</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    {{ $permission->display_name }}
                                </td>
                                <td>
                                    {!! $permission->description !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $permissions->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @else
            <p class="alert alert-warning">No permission created yet.</p>
        @endif
    </section>
    <!-- /.content -->
@endsection
