<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Update {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/alpine.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- Only include the dashboard js when user is on dashboard page --}}
    @if( (request()->is('dashboard')) )
        <script src="{{ asset('js/dashboard.js') }}"></script>
    @endif
</head>
<body class="bg-teal-100">

<div class="flex items-center justify-center">
    <div class="mt-24 w-8/12 md:w-6/12 lg:w-4/12 bg-white shadow-xl rounded-lg p-5">
        <div class="flex justify-center mb-5">
            <i class="text-6xl {{ $failed ? 'text-red-500 icon-close' : 'text-green-500 icon-check' }}"></i>
        </div>
        <p class="text-center font-black text-xl">
            {{ $failed ? 'Fallimento' : 'Successo' }}
        </p>
        <p class="text-center">
            {{ $message }}
        </p>
    </div>
</div>

</body>
</html>
