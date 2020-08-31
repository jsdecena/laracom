@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.couriers.update', $courier->id) }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ $courier->name ?: old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description </label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{{ $courier->description ?: old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="URL">URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">http://</span>
                            <input type="text" name="url" id="url" placeholder="Link" class="form-control" value="{{ $courier->url ?: old('url') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="is_free">Free Delivery? </label>
                        <select name="is_free" id="is_free" class="form-control">
                            <option value="0" @if($courier->is_free == 0) selected="selected" @endif>No</option>
                            <option value="1" @if($courier->is_free == 1) selected="selected" @endif>Yes</option>
                        </select>
                    </div>
                    <div class="form-group" @if($courier->is_free == 1) style="display: none" @endif id="delivery_cost">
                        <label for="cost">Delivery Cost <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">{{config('cart.currency')}}</span>
                            <input class="form-control" type="text" id="cost" name="cost" placeholder="{{config('cart.currency')}}" value="{{$courier->cost}}">
                        </div>
                    </div>
                    <div class="form-group">
                        @include('admin.shared.status-select', ['status' => $courier->status])
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.couriers.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
