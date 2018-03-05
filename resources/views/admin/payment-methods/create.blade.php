@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('layouts.errors-and-messages')
        <!-- Default box -->
        <div class="box">
            <form action="{{ route('admin.payment-methods.store') }}" method="post">
            <div class="box-body">
                <h2> <i class="fa fa-flask"></i> Payment Method</h2>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Name" autofocus>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="10" class="form-control ckeditor">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="account_id">Account ID</label>
                    <input class="form-control" type="text" name="account_id" id="account_id" value="{{ old('account_id') }}" placeholder="Account ID">
                </div>
                <div class="form-group">
                    <label for="client_id">Client ID</label>
                    <input class="form-control" type="text" name="client_id" id="client_id" value="{{ old('client_id') }}" placeholder="Client ID">
                </div>
                <div class="form-group">
                    <label for="client_secret">Client secret</label>
                    <input class="form-control" type="text" name="client_secret" id="client_secret" value="{{ old('client_secret') }}" placeholder="Client secret">
                </div>
                <div class="form-group">
                    <label for="api_url">Payment URL</label>
                    <div class="input-group">
                        <span class="input-group-addon">http://</span>
                        <input class="form-control" type="text" name="api_url" id="api_url" value="{{ old('api_url') }}" placeholder="URL to go for processing order">
                    </div>
                </div>
                <div class="form-group">
                    <label for="redirect_url">Redirect URL</label>
                    <div class="input-group">
                        <span class="input-group-addon">http://</span>
                        <input class="form-control" type="text" name="redirect_url" id="redirect_url" value="{{ old('redirect_url') }}" placeholder="URL to go after checkout">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cancel_url">Cancel URL</label>
                    <div class="input-group">
                        <span class="input-group-addon">http://</span>
                        <input class="form-control" type="text" name="cancel_url" id="cancel_url" value="{{ old('cancel_url') }}" placeholder="URL to go after customer cancel the checkout">
                    </div>
                </div>
                <div class="form-group">
                    <label for="failed_url">Failed URL</label>
                    <div class="input-group">
                        <span class="input-group-addon">http://</span>
                        <input class="form-control" type="text" name="failed_url" id="failed_url" value="{{ old('failed_url') }}" placeholder="URL to go when payment failed">
                    </div>
                </div>
                <label for="status">Status </label>
                <select name="status" id="status" class="form-control">
                    <option value="0" selected="selected">Disable</option>
                    <option value="1">Enable</option>
                </select>
            </div>
            <!-- /.box-body -->
                <div class="box-footer btn-group">
                    <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
