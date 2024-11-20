<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MOCHIUTA') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- bootstrap -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="w-100 vh-100 position-relative video-wrapper">
        <video class="w-100 vh-100 object-fit-cover position-absolute top-0 left-0" src="{{asset('storage/title.mp4')}}" muted autoplay loop></video>
        <div class="position-absolute top-50 start-50 translate-middle">
            <img src="{{asset('storage/logo_transparent.png')}}">
            <div class="d-flex justify-content-center">
                <a href="{{ route('mypage')}}">
                    <button type="button" class="btn btn-primary">ログイン</button>
                </a>
            </div>
            <div class="d-flex justify-content-center">
                <a href="{{ route('register') }}">
                    新規登録はコチラ
                </a>
            </div>
            <div class="d-flex justify-content-center">
                <a href="{{ route('test') }}">
                    テスト用
                </a>
            </div>
        </div>
</body>

</html>