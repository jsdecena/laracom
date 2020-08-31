@if(!$products->isEmpty())
<div class="row">
    <div class="col-md-12">
        <!-- <div class="row header hidden-xs hidden-sm"> -->
        <div class="row hidden-xs hidden-sm" style="height: 40px;">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><b>Cover</b></div>
                </div>
            </div>

            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                <div class="row">
                    <div class="col-lg-5 col-md-5"><b>Name</b></div>
                    <div class="col-lg-2 col-md-2"><b>Quantity</b></div>
                    <div class="col-lg-1 col-md-1"><b>Remove</b></div>
                    <div class="col-lg-2 col-md-2"><b>Price</b></div>
                    <div class="col-lg-2 col-md-2"><b>Total</b></div>
                </div>
            </div>
        </div>
        @foreach($cartItems as $cartItem)
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <a href="{{ route('front.get.product', [$cartItem->product->slug]) }}" class="hover-border">
                                @if(isset($cartItem->cover))
                                    <img src="{{$cartItem->cover}}" alt="{{ $cartItem->name }}" class="img-responsive img-thumbnail">
                                @else
                                    <img src="https://placehold.it/120x120" alt="" class="img-responsive img-thumbnail">
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <h4 style="margin-bottom:5px;">{{ $cartItem->name }}</h4>
                            @if($cartItem->options->has('combination'))
                                <div style="margin-bottom:5px;">
                                @foreach($cartItem->options->combination as $option)
                                    <small class="label label-primary">{{$option['value']}}</small>
                                @endforeach
                                </div>
                            @endif
                            <!-- <div class="product-description"> -->
                                {!! $cartItem->product->description !!}
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-8">
                            <form action="{{ route('cart.update', $cartItem->rowId) }}" class="form-inline" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <div class="input-group">
                                    <input type="text" name="quantity" value="{{ $cartItem->qty }}" class="form-control input-sm" />
                                    <span class="input-group-btn"><button class="btn btn-default btn-sm">Update</button></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-8 col-xs-4">
                            <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                            </form>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <span class="hidden-lg hidden-md"><small>Tax: </span>
                            {{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->tax), 2) }}</small>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <span class="hidden-lg hidden-md"><small>Subtotal: </span>
                            {{config('cart.currency')}} {{ number_format($cartItem->price, 2) }}</small>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <span class="hidden-lg hidden-md"><small>Total: </span>
                            {{config('cart.currency')}} {{ number_format(($cartItem->qty*$cartItem->price), 2) }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
    </div>
</div>
@endif
<script type="text/javascript">
    $(document).ready(function () {
        let courierRadioBtn = $('input[name="rate"]');
        courierRadioBtn.click(function () {
            $('#shippingFee').text($(this).data('fee'));
            let totalElement = $('span#grandTotal');
            let shippingFee = $(this).data('fee');
            let total = totalElement.data('total');
            let grandTotal = parseFloat(shippingFee) + parseFloat(total);
            totalElement.html(grandTotal.toFixed(2));
        });
    });
</script>
