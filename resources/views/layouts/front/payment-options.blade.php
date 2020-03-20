@if(isset($payment['name']))
    @if($payment['name'] == config('stripe.name'))
        @include('front.payments.stripe')
    @elseif($payment['name'] == config('paypal.name'))
        @include('front.payments.paypal')
    @elseif($payment['name'] == config('bank-transfer.name'))
        @include('front.payments.bank-transfer')
    @elseif($payment['name'] == config('pay-on-delivery.name'))
        @include('front.payments.pay-on-delivery')
    @endif
@endif