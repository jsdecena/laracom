@extends('layouts.front.app')

@section('content')
    <!-- Main content -->
    <section class="container content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('customer.address.store', $customer->id) }}" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="status" value="1">
                <div class="box-body">
                    {{ csrf_field() }}
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
                        <select name="country_id" id="country_id" class="form-control select2">
                            @foreach($countries as $country)
                                <option @if(env('SHOP_COUNTRY_ID') == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="provinces" class="form-group" style="display: none;"></div>
                    <div id="cities" class="form-group" style="display: none;"></div>
                    <div class="form-group">
                        <label for="zip">Zip Code </label>
                        <input type="text" name="zip" id="zip" placeholder="Zip code" class="form-control" value="{{ old('zip') }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Your Phone </label>
                        <input type="text" name="phone" id="phone" placeholder="Phone number" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('accounts', ['tab' => 'address']) }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@section('css')
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js') }}"></script>
    <script type="text/javascript">

        function findProvinceOrState(countryId) {
            $.ajax({
                url : '/api/v1/country/' + countryId + '/province',
                contentType: 'json',
                success: function (res) {
                    if (res.data.length > 0) {
                        let html = '<label for="province_id">Provinces </label>';
                        html += '<select name="province_id" id="province_id" class="form-control select2">';
                        $(res.data).each(function (idx, v) {
                            html += '<option value="'+ v.id+'">'+ v.name +'</option>';
                        });
                        html += '</select>';

                        $('#provinces').html(html).show();
                        $('.select2').select2();

                        findCity(countryId, 1);

                        $('#province_id').change(function () {
                            var provinceId = $(this).val();
                            findCity(countryId, provinceId);
                        });
                    } else {
                        $('#provinces').hide().html('');
                        $('#cities').hide().html('');
                    }
                }
            });
        }

        function findCity(countryId, provinceOrStateId) {
            $.ajax({
                url: '/api/v1/country/' + countryId + '/province/' + provinceOrStateId + '/city',
                contentType: 'json',
                success: function (data) {
                    let html = '<label for="city_id">City </label>';
                    html += '<select name="city_id" id="city_id" class="form-control select2">';
                    $(data.data).each(function (idx, v) {
                        html += '<option value="'+ v.id+'">'+ v.name +'</option>';
                    });
                    html += '</select>';

                    $('#cities').html(html).show();
                    $('.select2').select2();
                },
                errors: function (data) {
                    console.log(data);
                }
            });
        }
        
        function findUsStates() {
            $.ajax({
                url : '/country/' + countryId + '/state',
                contentType: 'json',
                success: function (res) {
                    if (res.data.length > 0) {
                        let html = '<label for="state_code">States </label>';
                        html += '<select name="state_code" id="state_code" class="form-control select2">';
                        $(res.data).each(function (idx, v) {
                            html += '<option value="'+ v.state_code+'">'+ v.state +'</option>';
                        });
                        html += '</select>';

                        $('#provinces').html(html).show();
                        $('.select2').select2();

                        findUsCities('AK');

                        $('#state_code').change(function () {
                            let state_code = $(this).val();
                            findUsCities(state_code);
                        });
                    } else {
                        $('#provinces').hide().html('');
                        $('#cities').hide().html('');
                    }
                }
            });
        }

        function findUsCities(state_code) {
            $.ajax({
                url : '/state/' + state_code + '/city',
                contentType: 'json',
                success: function (res) {
                    if (res.data.length > 0) {
                        let html = '<label for="city">City </label>';
                        html += '<select name="city" id="city" class="form-control select2">';
                        $(res.data).each(function (idx, v) {
                            html += '<option value="'+ v.name+'">'+ v.name +'</option>';
                        });
                        html += '</select>';

                         $('#cities').html(html).show();
                         $('.select2').select2();

                        $('#state_code').change(function () {
                            let state_code = $(this).val();
                            findUsCities(state_code);
                        });
                    } else {
                        $('#provinces').hide().html('');
                        $('#cities').hide().html('');
                    }
                }
            });
        }

        let countryId = +"{{ env('SHOP_COUNTRY_ID') }}";

        $(document).ready(function () {

            if (countryId === 226) {
                findUsStates(countryId);
            } else {
                findProvinceOrState(countryId);
            }

            $('#country_id').on('change', function () {
                countryId = +$(this).val();
                if (countryId === 226) {
                    findUsStates(countryId);
                } else {
                    findProvinceOrState(countryId);
                }

            });

            $('#city_id').on('change', function () {
                cityId = $(this).val();
                findProvinceOrState(countryId);
            });

            $('#province_id').on('change', function () {
                provinceId = $(this).val();
                findProvinceOrState(countryId);
            });
        });
    </script>
@endsection
