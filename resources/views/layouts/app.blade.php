<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        {{--  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">  --}}

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <title>Laravel App - @yield('title')</title>
    </head>
    <body >
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white 
        border-bottom shadow-sm mb-3">
            <h5 class="my-0 mr-md-auto font-weight-normal">Laravel App</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-dark" href="{{ route('home.index') }}" >Home</a>
                <a class="p-2 text-dark" href="{{ route('home.contact') }}">Contact</a>
                <a class="p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>
                <a class="p-2 text-dark" href="{{ route('posts.create') }}">Add Blog Post</a>

                @guest
                    @if (Route::has('register'))
                        <a class="p-2 text-dark" href="{{ route('register') }}" >Register</a>
                    @endif
                    <a class="p-2 text-dark" href="{{ route('login') }}" >Login</a>
                @else
                    <a class="p-2 text-dark" href="{{ route('logout') }}" 
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Logout ({{ Auth::user()->name }})
                    </a>
                    <form id="logout-form" action={{ route('logout') }} method="POST" style="display:none">
                        @csrf
                    </form>
                @endguest
            </nav>
        </div>
        <div class="container">
            @if (session('status'))
                <div style="background: red; color:white">
                    {{ session('status') }}
                </div>
                
            @endif
             @yield('content')
        </div>
       
    </body>
</html>

