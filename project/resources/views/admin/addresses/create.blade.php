@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.addresses.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="customer">Customers </label>
                        <select name="customer" id="status" class="form-control select2">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alias">Alias <span class="text-danger">*</span></label>
                        <input type="text" name="alias" id="alias" placeholder="Home or Office" class="form-control" value="{{ old('alias') }}">
                    </div>
                    <div class="form-group">
                        <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_1" id="address_1" placeholder="Address 1" class="form-control" value="{{ old('address_1') }}">
                    </div>
                    <div class="form-group">
                        <label for="address_2">Address 2 </label>
                        <input type="text" name="address_2" id="address_2" placeholder="Address 2" class="form-control" value="{{ old('address_2') }}">
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country </label>
                        <select name="country_id" id="country_id" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="province_id">Province </label>
                        <select name="province_id" id="province_id" class="form-control" disabled>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="cities" class="form-group">
                        <label for="city_id">City </label>
                        <select name="city_id" id="city_id" class="form-control" disabled>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip Code </label>
                        <input type="text" name="zip" id="zip" placeholder="Zip code" class="form-control" value="{{ old('zip') }}">
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
                        <a href="{{ route('admin.addresses.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#province_id').change(function () {

                var provinceId = $(this).val();

                $.ajax({
                    url: '/api/v1/country/169/province/' + provinceId + '/city',
                    contentType: 'json',
                    success: function (data) {

                        var html = '<label for="city_id">City </label>';
                            html += '<select name="city_id" id="city_id" class="form-control">';
                            $(data.data).each(function (idx, v) {
                                html += '<option value="'+ v.id+'">'+ v.name +'</option>';
                            });
                            html += '</select>';

                        $('#cities').html(html).show();
                    },
                    errors: function (data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection
