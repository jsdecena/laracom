@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.countries.update', $country->id) }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $country->name ?: old('name')  !!}">
                    </div>
                    <div class="form-group">
                        <label for="iso">ISO <span class="text-danger">*</span></label>
                        <input type="text" name="iso" id="iso" placeholder="ISO" class="form-control" value="{!! $country->iso ?: old('iso')  !!}">
                    </div>
                    <div class="form-group">
                        <label for="iso3">ISO-3 </label>
                        <input type="text" name="iso3" id="iso3" placeholder="ISO 3" class="form-control" value="{!! $country->iso3 ?: old('iso3')  !!}">
                    </div>
                    <div class="form-group">
                        <label for="numcode">Numcode </label>
                        <input type="text" name="numcode" id="numcode" placeholder="ISO 3" class="form-control" value="{!! $country->numcode ?: old('numcode')  !!}">
                    </div>
                    <div class="form-group">
                        <label for="phonecode">Phone code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" name="phonecode" id="phonecode" placeholder="Phone code" class="form-control" value="{!! $country->phonecode ?: old('phonecode')  !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0" @if($country->status == 0) selected="selected" @endif>Disable</option>
                            <option value="1" @if($country->status == 1) selected="selected" @endif>Enable</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.countries.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
