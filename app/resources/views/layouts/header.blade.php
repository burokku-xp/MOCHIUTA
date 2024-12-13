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
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('stylesheet')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark p-1">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="{{ url('/mypage') }}"><!-- マイページへ遷移-->
                    <img src="{{ asset('storage/logo_white.png') }}" alt="" width="60" height="auto"
                        class="">
                </a>
                <div class="mv-navbar-control">
                    <span class="my-navbar-item text-light">{{ Auth::user()->name }}／</span>
                    <a href="#" id="logout" class="mt-navbar-item">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
                <a class="my-navbar-item text-light link-offset-3-hover link-underline link-underline-dark link-underline-opacity-0 link-underline-opacity-75-hover"
                    href="{{ url('/mypage') }}">マイページ</a>
                <a class="my-navbar-item text-light link-offset-3-hover link-underline link-underline-dark link-underline-opacity-0 link-underline-opacity-75-hover"
                    data-bs-toggle="collapse" data-bs-target="#navbarTogglerUserSearch"
                    aria-controls="navbarTogglerUserSearch" aria-expanded="false" aria-label="Toggle navigation"
                    href="#">ユーザー検索</a>
                <div class="collapse navbar-collapse" id="navbarTogglerUserSearch">
                    <div class="d-flex align-middle column-gap-3">
                        <form class="d-flex" role="search" action="{{ route('user.searchResult') }}" method="post" onsubmit="return false;">
                            @csrf
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                                name="userSearch">
                            <button class="btn btn-success usersearch_btn" type="button">Search</button>
                        </form>
                        <div id="userseach_result" class="column-gap-3 d-flex">
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('/js/form.js') }}"></script>
</body>


</html>
