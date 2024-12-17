@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div>
            <p>入力いただいたメールアドレス宛にパスワード再設定ページのURLを</p>
            <p>メール送信しました。</p>
            <p>メールのURLをクリックして新しいパスワードを設定してください。</p>
        </div>
        <a href="{{ route('title') }}" id="logout" class="mt-navbar-item">
            <button class="btn btn-primary">トップへ戻る</button>
        </a>
    </div>
</div>
@endsection