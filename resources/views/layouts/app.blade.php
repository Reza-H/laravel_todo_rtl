<!DOCTYPE html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')

    <title>{{ config('app.name', 'Laravel') }}</title>

</head>
<body>
<div id="app">
    <header>
        @include('partials.header')
    </header>
    <main class="py-4">
        @yield('content')
    </main>
</div>



<footer class="container-fluid text-center mt-2 fixed-bottom">
    @include('partials.footer')
    @section('plusbtn')
    @parent
    @endsection

</footer>

<script src="{{ asset('js/main.js') }}" defer></script>
<script src="{{ asset('js/footer.js') }}" defer></script>

@yield('custom_js')
</body>
</html>
