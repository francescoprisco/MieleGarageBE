<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Payment - {{ config('app.name') }}</title>
    @include('layouts.headerstripe')

</head>
<body class="bg-teal-100">

{{-- handle stripe --}}
@if( $paymentOption->slug == "stripe" )
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ $paymentOption->public_key }}');
        var sessionId = '{{ $data }}';
    </script>
    <script src="{{ asset('js/stripe-payment.js') }}"></script>
@endif

</body>
</html>
