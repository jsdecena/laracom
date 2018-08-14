<div class="row">
    <div class="col-md-6">
        <ul id="thumbnails" class="col-md-4 list-unstyled">
            <li>
                <a href="javascript: void(0)">
                    @if(isset($product->cover))
                        <img class="img-responsive img-thumbnail"
                             src="{{ asset("storage/$product->cover") }}"
                             alt="{{ $product->name }}"/>
                    @else
                        <img class="img-responsive img-thumbnail"
                             src="{{ asset("https://placehold.it/180x180") }}"
                             alt="{{ $product->name }}"/>
                    @endif
                </a>
            </li>
            @if(isset($images) && !$images->isEmpty())
                @foreach($images as $image)
                    <li>
                        <a href="javascript: void(0)">
                            <img class="img-responsive img-thumbnail"
                                 src="{{ asset("storage/$image->src") }}"
                                 alt="{{ $product->name }}"/>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
        <figure class="text-center product-cover-wrap col-md-8">
            @if(isset($product->cover))
                <img id="main-image" class="product-cover img-responsive"
                     src="{{ asset("storage/$product->cover") }}?w=400"
                     data-zoom="{{ asset("storage/$product->cover") }}?w=1200">
            @else
                <img id="main-image" class="product-cover" src="https://placehold.it/300x300"
                     data-zoom="{{ asset("storage/$product->cover") }}?w=1200" alt="{{ $product->name }}">
            @endif
        </figure>
    </div>
    <div class="col-md-6">
        <div class="product-description">
            <h1>{{ $product->name }}
                @php
                    $price = isset($comboPriceRange) && !is_null($comboPriceRange) ? $comboPriceRange : $product->price;
                @endphp
                <small>{{ config('cart.currency') }} {{ $price }}</small>
            </h1>
            <div class="description">{!! $product->description !!}</div>
            <div class="excerpt">
                <hr>{!!  str_limit($product->description, 100, ' ...') !!}</div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.errors-and-messages')
                    <form action="{{ route('cart.store') }}" class="form-inline" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                        @if(!empty($combinationElements))
                            <label for="">Choose Combination</label> <br/>
                            @foreach($combinationElements as $attributeName => $attributeValue)
                                @if($attributeName == 'color')
                                        <b>{{ucwords($attributeName)}} : </b><br>
                                        <div class="dlk-radio btn-group">
                                        @foreach($attributeValue as $colorValues)
                                        <label class="btn" style="background-color: {{ $colorValues }}">
                                            <input name="color-attr" class="form-control" type="radio" value="{{ $colorValues }}" required>
                                            <i class="fa fa-check glyphicon glyphicon-ok"></i>
                                        </label>
                                        @endforeach
                                    </div><br><br>
                                @else
                                    <div>
                                        <b>{{ucwords($attributeName)}} : </b><br>
                                    @foreach($attributeValue as $values)
                                    <label class="radio">{{ $values }}
                                        <input type="radio" name="{{ $attributeName }}-attr" required value="{{$values}}">
                                        <span class="checkround"></span>
                                    </label>
                                    @endforeach
                                    </div><br>
                                @endif
                            @endforeach
                        @endif
                        @if(isset($productAttributes) && !$productAttributes->isEmpty())
                                {{--<label for="productAttribute">Choose Combination</label> <br/>--}}
                                {{--<select name="productAttribute" id="productAttribute" class="form-control select2">--}}
                                    {{--@foreach($productAttributes as $productAttribute)--}}
                                        {{--<option value="{{ $productAttribute->id }}">--}}
                                            {{--@foreach($productAttribute->attributesValues as $value)--}}
                                                {{--{{ $value->attribute->name }} : {{ ucwords($value->value) }}--}}
                                            {{--@endforeach--}}
                                            {{--@if(!is_null($productAttribute->price))--}}
                                                {{--( {{ config('cart.currency') }} {{ $productAttribute->price }})--}}
                                            {{--@endif--}}
                                        {{--</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                        @endif
                        </div>
                        <hr>
                        @if(isset($category) && $category->slug == 'eyewear')
                            @foreach(config('eyewear_options') as $key => $value)
                                <label class="radio">{{$value['name']}}
                                    <input type="radio" name="eyewear_options" required value="{{$key}}">
                                    <span class="checkround"></span>
                                </label>
                                <div class="modal fade" id="{{$key}}" role="dialog">
                                    <div class="modal-dialog modal-sm vertical-align-center">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close modal_close" id="modal_close_x"
                                                        data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title"> Select the appropriate lenses
                                                    for {{$value['name']}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-container-eyewear-options">
                                                    @foreach($value['options'] as $option)
                                                        <div class="col-eyewear-details">
                                                            <label class="radio">{{$option['name']}}
                                                                <input type="radio" class="radioToUncheck"
                                                                       name="sub-option" required
                                                                       value="{{$option['name']}}-{{$option['price']}}">
                                                                <span class="checkround"></span>
                                                            </label><br>
                                                            <label class="radio">Price
                                                                : {{ config('cart.currency') }} {{$option['price']}}</label>
                                                            <br>
                                                            <span>
                                                                {{$option['description'] ?? ''}}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning"><i
                                                            class="fa fa-cart-plus"></i> Add to cart
                                                </button>
                                                <button type="button" data-dismiss="modal"
                                                        class="btn btn-default modal_close" id="modal-close">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <br><br>
                        <input type="hidden" name="quantity" id="quantity" value="1"/>
                        <input type="hidden" name="product" value="{{ $product->id }}"/>
                        @if(isset($allCombinations) && !is_null($allCombinations))
                            <input type="hidden" name="allCombinations" value="{{ $allCombinations }}"/>
                        @endif
                        <button type="submit" class="btn btn-warning"><i
                                    class="fa fa-cart-plus"></i> Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var productPane = document.querySelector('.product-cover');
            var paneContainer = document.querySelector('.product-cover-wrap');

            new Drift(productPane, {
                paneContainer: paneContainer,
                inlinePane: false
            });
        });
    </script>
@endsection