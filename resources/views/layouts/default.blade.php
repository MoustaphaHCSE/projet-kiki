<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body>
@include('includes.navbar')
<div class="container">
    @yield('content')
</div>
<footer class="container">
    @include('includes.footer')
</footer>
</body>
</html>
