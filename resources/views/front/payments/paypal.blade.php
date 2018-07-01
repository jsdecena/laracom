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
            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-success pull-right">Pay with {{ ucwords($payment['name']) }} <i class="fa fa-paypal"></i></button>
        </form>
    </td>
</tr>