<title>@yield('title')</title>

<!-- Style -->
@stack('prepend-style')
@include('includes.style')
@stack('addon-style')


<div class="page-content" id="mainApp">
    <div id="divUtama">

        <!-- Page Content -->
        @yield('content')

    </div>

</div>

<!-- Navbar -->
@include('includes.navbar')

<!-- Footer -->
@include('includes.footer')

<!-- Script -->
@stack('prepend-script')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>

@include('includes.script')
@stack('addon-script')
