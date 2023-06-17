<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body style="overflow-x: hidden !important;">
<header class="row mb-5">
    @include('includes.header')
</header>
<div id="main" class="row mt-5 mb-5">
    @yield('content')
</div>
<footer class="row mt-5">
    @include('includes.footer')
</footer>
</body>
</html>
