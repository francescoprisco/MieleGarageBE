<link rel="stylesheet" href="{{ asset('css/fonts.min.css') }}" >
<link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/font.awesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/simpleline.icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/selectize.default.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="icon" href="{{ asset('css/style.css') }}">
<livewire:styles />

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/selectize.min.js') }}"></script>

<script src="{{ asset('js/font.awesome.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/feather.min.js') }}"></script>
@livewireScripts
<x-livewire-alert::scripts />
<script src="{{ asset('js/alpine.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
{{-- Only include the dashboard js when user is on dashboard page --}}
@if( (request()->is('dashboard')) )
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endif
