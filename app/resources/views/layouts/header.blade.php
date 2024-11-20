<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('stylesheet')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark p-1">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="{{ url('/mypage')}}"><!-- マイページへ遷移-->
                    <img src="{{asset('storage/logo_white.png')}}" alt="" width="60" height="auto" class="">
                </a>
                <div class="mv-navbar-control">
                    <span class="my-navbar-item text-light">{{ Auth::user()->name }}／</span>
                    <a href="#" id="logout" class="mt-navbar-item">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <script>
                        document.getElementById('logout').addEventListener('click', function(event) {
                            event.preventDefault();
                            document.getElementById('logout-form').submit();
                        });
                    </script>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-dark" style="background-color:#ee7800">
            <div>
                <a class="my-navbar-item text-light link-offset-3-hover link-underline link-underline-dark link-underline-opacity-0 link-underline-opacity-75-hover" href="#">マイページ</a>
                <a class="my-navbar-item text-light link-offset-3-hover link-underline link-underline-dark link-underline-opacity-0 link-underline-opacity-75-hover" href="#">ユーザー検索</a>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('/js/form.js') }}"></script>
</body>

</html>