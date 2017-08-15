@component('mail::message')

# Inquiry Message from the website

## Name : {{ $from }}

## Email : {{ $email }}

## Person type : {{ $iam }}

## Message : {{ $message }}

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
