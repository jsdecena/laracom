@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="parent">Parent Category</label>
                        <select name="parent" id="parent" class="form-control select2">
                            @foreach($categories as $cat)
                                <option @if($cat->id == $category->parent_id) selected="selected" @endif value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $category->name ?: old('name')  !!}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{!! $category->description ?: old('description')  !!}</textarea>
                    </div>
                    @if(isset($category->cover))
                    <div class="form-group">
                        <img src="{{ asset("storage/$category->cover") }}" alt="" class="img-responsive"> <br/>
                        <a onclick="return confirm('Are you sure?')" href="{{ route('admin.category.remove.image', ['category' => $category->id]) }}" class="btn btn-danger">Remove image?</a>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="cover">Cover </label>
                        <input type="file" name="cover" id="cover" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Status </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0" @if($category->status == 0) selected="selected" @endif>Disable</option>
                            <option value="1" @if($category->status == 1) selected="selected" @endif>Enable</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
