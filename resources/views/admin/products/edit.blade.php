@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="tablist">
                                <li role="presentation" @if(!request()->has('combination')) class="active" @endif><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Info</a></li>
                                <li role="presentation" @if(request()->has('combination')) class="active" @endif><a href="#combinations" aria-controls="profile" role="tab" data-toggle="tab">Combinations</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content" id="tabcontent">
                                <div role="tabpanel" class="tab-pane @if(!request()->has('combination')) active @endif" id="info">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h2>{{ ucfirst($product->name) }}</h2>
                                            <div class="form-group">
                                                <label for="sku">SKU <span class="text-danger">*</span></label>
                                                <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{!! $product->sku !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $product->name !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description </label>
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{!! $product->description  !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <img src="{{ $product->cover }}" alt="" class="img-responsive img-thumbnail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="cover">Cover </label>
                                                <input type="file" name="cover" id="cover" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                @foreach($images as $image)
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <img src="{{ asset("storage/$image->src") }}" alt="" class="img-responsive img-thumbnail"> <br /> <br>
                                                            <a onclick="return confirm('Are you sure?')" href="{{ route('admin.product.remove.thumb', ['src' => $image->src]) }}" class="btn btn-danger btn-sm btn-block">Remove?</a><br />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="image">Images </label>
                                                <input type="file" name="image[]" id="image" class="form-control" multiple>
                                                <span class="text-warning">You can use ctr (cmd) to select multiple images</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                                @if($productAttributes->isEmpty())
                                                    <input
                                                            type="text"
                                                            name="quantity"
                                                            id="quantity"
                                                            placeholder="Quantity"
                                                            class="form-control"
                                                            value="{!! $product->quantity  !!}"
                                                    >
                                                @else
                                                    <input type="hidden" name="quantity" value="{{ $qty }}">
                                                    <input type="text" value="{{ $qty }}" class="form-control" disabled>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Note: Quantity is disabled. Total quantity is calculated by the sum of all the combinations.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                @if($productAttributes->isEmpty())
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="{!! $product->price !!}">
                                                    </div>
                                                @else
                                                    <input type="hidden" name="price" value="{!! $product->price !!}">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" id="price" placeholder="Price" class="form-control" value="{!! $product->price !!}" disabled>
                                                    </div>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Note: Price is disabled. Price is derived based on the combination.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="sale_price">Sale Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                    <input type="text" name="sale_price" id="sale_price" placeholder="Sale Price" class="form-control" value="{{ $product->sale_price }}">
                                                </div>
                                            </div>
                                            @if(!$brands->isEmpty())
                                                <div class="form-group">
                                                    <label for="brand_id">Brand </label>
                                                    <select name="brand_id" id="brand_id" class="form-control select2">
                                                        <option value=""></option>
                                                        @foreach($brands as $brand)
                                                            <option @if($brand->id == $product->brand_id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                @include('admin.shared.status-select', ['status' => $product->status])
                                            </div>
                                            @include('admin.shared.attribute-select', [compact('default_weight')])
                                            <!-- /.box-body -->
                                        </div>
                                        <div class="col-md-4">
                                            <h2>Categories</h2>
                                            @include('admin.shared.categories', ['categories' => $categories, 'ids' => $product])
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="box-footer">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm">Back</a>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane @if(request()->has('combination')) active @endif" id="combinations">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @include('admin.products.create-attributes', compact('attributes'))
                                        </div>
                                        <div class="col-md-8">
                                            @include('admin.products.attributes', compact('productAttributes'))
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
@section('css')
    <style type="text/css">
        label.checkbox-inline {
            padding: 10px 5px;
            display: block;
            margin-bottom: 5px;
        }
        label.checkbox-inline > input[type="checkbox"] {
            margin-left: 10px;
        }
        ul.attribute-lists > li > label:hover {
            background: #3c8dbc;
            color: #fff;
        }
        ul.attribute-lists > li {
            background: #eee;
        }
        ul.attribute-lists > li:hover {
            background: #ccc;
        }
        ul.attribute-lists > li {
            margin-bottom: 15px;
            padding: 15px;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        function backToInfoTab() {
            $('#tablist > li:first-child').addClass('active');
            $('#tablist > li:last-child').removeClass('active');

            $('#tabcontent > div:first-child').addClass('active');
            $('#tabcontent > div:last-child').removeClass('active');
        }
        $(document).ready(function () {
            const checkbox = $('input.attribute');
            $(checkbox).on('change', function () {
                const attributeId = $(this).val();
                if ($(this).is(':checked')) {
                    $('#attributeValue' + attributeId).attr('disabled', false);
                } else {
                    $('#attributeValue' + attributeId).attr('disabled', true);
                }
                const count = checkbox.filter(':checked').length;
                if (count > 0) {
                    $('#productAttributeQuantity').attr('disabled', false);
                    $('#productAttributePrice').attr('disabled', false);
                    $('#salePrice').attr('disabled', false);
                    $('#default').attr('disabled', false);
                    $('#createCombinationBtn').attr('disabled', false);
                    $('#combination').attr('disabled', false);
                } else {
                    $('#productAttributeQuantity').attr('disabled', true);
                    $('#productAttributePrice').attr('disabled', true);
                    $('#salePrice').attr('disabled', true);
                    $('#default').attr('disabled', true);
                    $('#createCombinationBtn').attr('disabled', true);
                    $('#combination').attr('disabled', true);
                }
            });
        });
    </script>
@endsection