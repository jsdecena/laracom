@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.couriers.store') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description </label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="URL">URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">http://</span>
                            <input type="text" name="url" id="url" placeholder="Link" class="form-control" value="{{ old('url') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="is_free">Is Free Delivery? </label>
                        <select name="is_free" id="is_free" class="form-control">
                            <option value="0">No</option>
                            <option value="1" selected="selected">Yes</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: none" id="delivery_cost">
                        <label for="cost">Delivery Cost <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">{{config('cart.currency')}}</span>
                            <input class="form-control" type="text" id="cost" name="cost" placeholder="{{config('cart.currency')}}" value="{{old('cost')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Disable</option>
                            <option value="1">Enable</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
