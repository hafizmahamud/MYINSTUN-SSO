<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Laravel Boilerplate')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}"> 
	    <link rel="stylesheet" href="{{ asset('css/animations.css')}}">
	    <link rel="stylesheet" href="{{ asset('css/font-awesome.css')}}">
	    <link rel="stylesheet" href="{{ asset('css/main.css')}}" class="color-switcher-link">
        @push('after-scripts')
	        <script src="js/modernizr-2.6.2.min.js"></script>
            <script src="js/compressed.js"></script>
            <script src="js/main.js"></script>  
            <script src="js/switcher.js"></script>  
        @endpush
        <!-- letak import javascript dkt sini -->
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}

        @stack('after-styles')
    </head>
    <body>
        @include('includes.partials.read-only')
        <div id="app">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')

            <div>
            <!-- <img class="center" style="height:200px; width:250px;" src="/img/myinstunlogo.png" /> -->
                @include('includes.partials.messages')
                @yield('content')
            </div><!-- container -->
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        @stack('after-scripts')

        @include('includes.partials.ga')
    </body>
</html>
<style>
    html, body {
        font-family: "Poppins", sans-serif;
	background-color: rgb(42 50 60);
    }
</style>
