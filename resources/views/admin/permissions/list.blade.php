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
                                <td>Actions</td>
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
                                <td>
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </form>
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
