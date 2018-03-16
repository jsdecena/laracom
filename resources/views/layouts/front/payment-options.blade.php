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
                <form action="{{ route('checkout.execute') }}" method="POST">
                    <input type="hidden" id="address_id" name="address" value="">
                    <input type="hidden" id="courier_id" name="courier" value="">
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
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('input[name="billing_address"]').on('change', function () {
                            var chosenAddressId = $(this).val();
                            $('#address_id').val(chosenAddressId);
                        });
                        $('input[name="courier"]').on('change', function () {
                            var chosenCourierId = $(this).val();
                            $('#courier_id').val(chosenCourierId);
                        });
                    });
                </script>
            @endif
        </td>
    </tr>
@else
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
                <label class="col-md-2 col-md-offset-3">
                    <input
                            type="radio"
                            class="form-control"
                            name="payment"
                            value="{{ $payment['name'] }}"
                            @if(old('payment') == $payment['name']) checked="checked"  @endif>
                </label>
            @endif
        </td>
    </tr>
@endif