@include('front.layouts.header')
<body class="d-flex flex-column min-vh-100">
    <x-front_navbar/>
    <main class="flex-grow-1">
        @yield('content')
    </main>
    @include('front.layouts.footer')
</body>
</html>
