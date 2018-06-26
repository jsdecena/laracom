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
                <form action="{{ route('checkout.execute') }}" method="post" class="pull-right" id="stripeForm">
                    <input type="hidden" name="payment" value="{{ config('stripe.name') }}">
                    <input type="hidden" name="stripeToken" value="">
                    <input type="hidden" class="address_id" name="billing_address" value="">
                    <input type="hidden" class="delivery_address_id" name="delivery_address" value="">
                    <input type="hidden" class="courier_id" name="courier" value="">
                    {{ csrf_field() }}
                    <button id="paywithstripe" class="btn btn-primary">Pay with Stripe <i class="fa fa-cc-stripe"></i></button>
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
            <form action="{{ route('checkout.store') }}" method="post" class="pull-right" id="payPalForm">
                {{ csrf_field() }}
                <input type="hidden" name="payment" value="{{ config('paypal.name') }}">
                <input type="hidden" class="address_id" name="billing_address" value="">
                <input type="hidden" class="delivery_address_id" name="delivery_address" value="">
                <input type="hidden" class="courier_id" name="courier" value="">
                <input type="hidden" id="shippingFeeC" value="0">
                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-success pull-right">Pay with PayPal <i class="fa fa-paypal"></i></button>
            </form>
        </td>
    </tr>
@endif

@section('js')

    <script src="{{ url('https://checkout.stripe.com/checkout.js') }}"></script>

    <script type="text/javascript">

        function setTotal(total, shippingCost) {
            var computed = +shippingCost + parseFloat(total);
            $('#total').html(computed.toFixed(2));
        }

        function setShippingFee(cost) {
            el = '#shippingFee';
            $(el).html(cost);
            $('#shippingFeeC').val(cost);
        }

        function setCourierDetails(courierId) {
            $('.courier_id').val(courierId);
        }

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

            var billingAddress = 'input[name="billing_address"]';
            $(billingAddress).on('change', function () {
                var chosenAddressId = $(this).val();
                $('.address_id').val(chosenAddressId);
                $('.delivery_address_id').val(chosenAddressId);
            });

            var deliveryAddress = 'input[name="delivery_address"]';
            $(deliveryAddress).on('change', function () {
                var chosenDeliveryAddressId = $(this).val();
                $('.delivery_address_id').val(chosenDeliveryAddressId);
            });

            var courier = 'input[name="courier"]';
            $(courier).on('change', function () {
                var shippingCost = $(this).data('cost');
                var total = $('#total').data('total');

                setCourierDetails($(this).val());
                setShippingFee(shippingCost);
                setTotal(total, shippingCost);
            });

            if ($(courier).is(':checked')) {
                var shippingCost = $(courier + ':checked').data('cost');
                var courierId = $(courier + ':checked').val();
                var total = $('#total').data('total');

                setShippingFee(shippingCost);
                setCourierDetails(courierId);
                setTotal(total, shippingCost);
            }

            var handler = StripeCheckout.configure({
                key: "{{ config('stripe.key') }}",
                locale: 'auto',
                token: function(token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log(token.id);
                    $('input[name="stripeToken"]').val(token.id);
                    $('#stripeForm').submit();
                }
            });

            document.getElementById('paywithstripe').addEventListener('click', function(e) {
                var total = parseFloat("{{ $total }}");
                var shipping = parseFloat($('#shippingFeeC').val());
                var amount = total + shipping;
                // Open Checkout with further options:
                handler.open({
                    name: "{{ config('stripe.name') }}",
                    description: "{{ config('stripe.description') }}",
                    currency: "{{ config('cart.currency') }}",
                    amount: amount * 100,
                    email: "{{ $customer->email }}"
                });
                e.preventDefault();
            });

            // Close Checkout on page navigation:
            window.addEventListener('popstate', function() {
                handler.close();
            });
        });
    </script>
@endsection