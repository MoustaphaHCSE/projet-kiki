<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body>
<div class="container">
    @yield('content')
</div>
<footer class="container">
    @include('includes.footer')
</footer>
</body>
</html>
