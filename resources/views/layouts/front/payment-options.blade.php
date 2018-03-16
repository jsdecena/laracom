@if(isset($payment['name']) && $payment['name'] == 'stripe')
    <tr>
        <td>
            @if(isset($payment['name']))
                {{ ucwords($payment['name']) }}
            @else
                <p class="alert alert-danger">You need to have <strong>name</strong> key in your config</p>
            @endif
        </td>
        <td>
            @if(isset($payment['description']))
                {{ $payment['description'] }}
            @endif
        </td>
        <td>
            @if(isset($payment['name']))
                <form action="{{ route('checkout.execute') }}" method="post" class="pull-right">
                    <input type="hidden" class="address_id" name="billing_address" value="">
                    <input type="hidden" class="delivery_address_id" name="delivery_address" value="">
                    <input type="hidden" class="courier_id" name="courier" value="">
                    {{ csrf_field() }}
                    <script
                            src="{{ url('https://checkout.stripe.com/checkout.js') }}" class="stripe-button"
                            data-key="{{ config('stripe.key') }}"
                            data-amount="{{ $total * 100 }}"
                            data-name="{{ ucwords(config('stripe.name')) }}"
                            data-description="{{ config('stripe.description') }}"
                            data-image="{{ url('https://stripe.com/img/documentation/checkout/marketplace.png') }}"
                            data-locale="auto"
                            data-currency="{{ config('cart.currency') }}">
                    </script>
                </form>
            @endif
        </td>
    </tr>
@elseif(isset($payment['name']) && $payment['name'] == 'paypal')
    <tr>
        <td>
            @if(isset($payment['name']))
                {{ ucwords($payment['name']) }}
            @else
                <p class="alert alert-danger">You need to have <strong>name</strong> key in your config</p>
            @endif
        </td>
        <td>
            @if(isset($payment['description']))
                {{ $payment['description'] }}
            @endif
        </td>
        <td>
            <form action="{{ route('checkout.store') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="payment" value="{{ config('paypal.name') }}">
                <input type="hidden" class="address_id" name="billing_address" value="">
                <input type="hidden" class="delivery_address_id" name="delivery_address" value="">
                <input type="hidden" class="courier_id" name="courier" value="">
                <button type="submit" class="btn btn-success pull-right">Pay with PayPal <i class="fa fa-paypal"></i></button>
            </form>
        </td>
    </tr>
@endif

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var clicked = false;
            $('#sameDeliveryAddress').on('change', function () {
                clicked = !clicked;
                if (clicked) {
                    $('#sameDeliveryAddressRow').show();
                } else {
                    $('#sameDeliveryAddressRow').hide();
                }
            });
            $('input[name="billing_address"]').on('change', function () {
                var chosenAddressId = $(this).val();
                $('.address_id').val(chosenAddressId);
                $('.delivery_address_id').val(chosenAddressId);
            });
            $('input[name="delivery_address"]').on('change', function () {
                var chosenDeliveryAddressId = $(this).val();
                $('.delivery_address_id').val(chosenDeliveryAddressId);
            });
            $('input[name="courier"]').on('change', function () {
                var chosenCourierId = $(this).val();
                $('.courier_id').val(chosenCourierId);
            });
        });
    </script>
@endsection