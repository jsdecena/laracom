@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <input type="hidden" value="put" name="_method">
                    <div class="form-group">
                        <label for="display_name">Display Name <span class="text text-danger">*</span></label>
                        <input type="text" name="display_name" id="display_name" placeholder="Display name" class="form-control" value="{{ old('display_name') ?: $role->display_name }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control ckeditor" placeholder="Description"> {!! old('description') ?: $role->description !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="permissions">Permissions</label>
                        <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple">
                            @foreach($permissions as $permission)
                                <option @if(in_array($permission->id, $attachedPermissionsArrayIds)) selected="selected" @endif value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <div class="btn-group">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
