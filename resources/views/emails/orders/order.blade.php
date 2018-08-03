@component('mail::message')
# Order Saved

Your order is successfully saved with us.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
