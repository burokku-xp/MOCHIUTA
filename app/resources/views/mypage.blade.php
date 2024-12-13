@extends('layouts.header')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class='text-center'>おすすめ</div>
                    </div>

                    <div id="iframe-container" class="card-body" style=" width:100%; height:72vh;">
                        <div class="iframe-wrapper">
                            <iframe style="border-radius:12px"
                                src="https://open.spotify.com/embed/playlist/37i9dQZEVXbKXQ4mDTEBXq?utm_source=generator&theme=0"
                                width="100%" height="352" frameBorder="0" allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"></iframe>
                        </div>
                        <div class="iframe-wrapper"><iframe style="border-radius:12px"
                                src="https://open.spotify.com/embed/playlist/37i9dQZEVXbMDoHDwVN2tF?utm_source=generator"
                                width="100%" height="352" frameBorder="0" allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"></iframe></div>
                        <div class="iframe-wrapper"><iframe style="border-radius:12px"
                                src="https://open.spotify.com/embed/playlist/37i9dQZF1DWYYQb2mqFd5I?utm_source=generator"
                                width="100%" height="352" frameBorder="0" allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"></iframe></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card row-gap-md-2">
                    <div class="card-header">
                        <div class='text-center'>リスト一覧</div>
                    </div>
                    <div class="card-body overflow-auto" style=" width:100%; height:70vh;">
                        <table class='table'>
                            <thead class='table'>
                                <tr>
                                    <th scope='col'>リスト名</th>
                                    <th scope='col'>公開状態</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <div class="overflow-auto">
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
                                </div>
                            </tbody>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#listRegistModal">新規リスト追加</a>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card row-gap-md-2">
                    <div class="card-header">
                        <div class='text-center'>お気に入りユーザー</div>
                    </div>
                    <div class="card-body" style=" width:100%; height:70vh;">
                        <table class='table'>
                            <thead class='table'>
                                <tr>
                                    <th scope='col'>お気に入りユーザー名</th>
                                    <th scope='col'></th>
                                </tr>
                            </thead>
                            <tbody class="favorite_tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <!-- モーダルウィンドウ -->
            <div class="modal fade" id="listRegistModal" tabindex="-1" aria-labelledby="listRegistModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="listRegistModalLabel">新規リスト登録</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                <button type="submit" class="btn btn-primary send-button"
                                    formaction="{{ route('list.Regist') }}">送信</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

    </div>
    </div>
    <!-- ログインユーザーのリスト -->
    </div>
@endsection
