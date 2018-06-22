@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$roles->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2>Roles</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Display Name</td>
                                <td>Description</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    {{ $role->display_name }}
                                </td>
                                <td>
                                    {!! $role->description !!}
                                </td>
                                <td>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @else
            <p class="alert alert-warning">No role created yet. <a href="{{ route('admin.roles.create') }}">Create one!</a></p>
        @endif
    </section>
    <!-- /.content -->
@endsection
