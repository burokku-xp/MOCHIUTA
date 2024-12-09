@extends('layouts.header')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class='text-center'>おすすめ</div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <iframe style="border-radius:12px"
                                src="https://open.spotify.com/embed/playlist/37i9dQZEVXbKXQ4mDTEBXq?utm_source=generator&theme=0"
                                width="100%" height="352" frameBorder="0" allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class='text-center'>お気に入りユーザー</div>
                    </div>
                    <div class="card-body">
                        <table class='table'>
                            <thead class='table'>
                                <tr>
                                    <th scope='col'>お気に入りユーザー名</th>
                                    <th scope='col'></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($favorite_users as $favorite_user)
                                    <tr>
                                        <th scope="col">
                                            <div class="btn-group dropend">
                                                <a href="" class="dropdown-toggle"
                                                    data-bs-toggle="dropdown">{{ $favorite_user['user_name'] }}</a>
                                                <ul class="dropdown-menu">
                                                    @foreach ($favorite_user['list_content'] as $list)
                                                        <div>
                                                            <a
                                                                href="{{ route('search.list', ['song_list' => $list['list_id']]) }}">{{ $list['list_name'] }}</a>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </th>
                                        <th scope="col">
                                            <div class="user_list">
                                                <a id="{{ $favorite_user['user_id'] }}"
                                                    class="link-dark link-offset-2 link-underline link-underline-opacity-0 favorite {{ $favorite_user['favorite'] }}"
                                                    href="#">☆</a>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ログインユーザーのリスト -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class='text-center'>リスト一覧</div>
                    </div>
                    <div class="card-body">
                        <table class='table'>
                            <thead class='table'>
                                <tr>
                                    <th scope='col'>リスト名</th>
                                    <th scope='col'>公開状態</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($song_list as $list)
                                    <tr>
                                        <th scope="col">
                                            <a
                                                href="{{ route('song.detail', ['song_list' => $list['id']]) }}">{{ $list['name'] }}</a>
                                        </th>
                                        <th scope="col">
                                            @if ($list['is_private'] == 0)
                                                公開
                                            @else
                                                非公開
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                    </div>
                </div>
                <div>
                    <!-- モーダルウィンドウ -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#listRegistModal">新規リスト追加</a>
                    <div class="modal fade" id="listRegistModal" tabindex="-1" aria-labelledby="listRegistModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="listRegistModalLabel">新規リスト登録</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form" action="{{ route('list.Regist') }}" method="post">
                                        @csrf
                                        <div class="panel-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $message)
                                                        <li>{{ $message }}</li>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="list-name" class="col-form-label">リスト名</label>
                                            <input type="text" class="form-control listname" name="name" required
                                                maxlength="20">
                                        </div>
                                        <div class="mb-3">
                                            <input type="radio" name="is_private" value="公開">公開
                                            <input type="radio" name="is_private" value="非公開" checked="checked">非公開
                                        </div>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-primary send-button"
                                            formaction="{{ route('list.Regist') }}">送信</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
