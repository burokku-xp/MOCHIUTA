@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div>
            <p>パスワードの再設定が完了しました。</p>
            <p>ログイン画面より再度ログインを行ってください。</p>
        </div>
        <a href="{{ route('title') }}" id="logout" class="mt-navbar-item">
            <button class="btn btn-primary">トップへ戻る</button>
        </a>
    </div>
</div>
@endsection