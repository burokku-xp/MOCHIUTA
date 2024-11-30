@extends('layouts.header')
@section('content')
    <div class="container">
        <h1 class='text-center'>一覧</h1>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            @foreach ($list_contents as $list_content)
                                <!--<table> 見た目整えるときdivのクラスをtableに付け替える-->
                                <div class= "change-flg">
                                    <tr scope="col" class="d-flex">
                                        <td>
                                            <div>曲名：{{ $list_content['name'] }}</div>
                                            <div>アーティスト名：{{ $list_content['artist'] }}</div>
                                        </td>
                                        <td>
                                            <audio controls
                                                src="{{ asset('storage/audio/' . $list_content['music_data_path']) }}"
                                                type="audio/*"></audio>
                                        </td>
                                        <td>
                                            <button id="comment-button-{{ $list_content['id'] }}"
                                                class="btn btn-primary btn-comment" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseExample-{{ $list_content['id'] }}"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                <div class="text-comment">コメントを開く</div>
                                            </button>
                                            <div class="collapse" id="collapseExample-{{ $list_content['id'] }}">
                                                <div class="card card-body">
                                                    {{ $list_content['comment'] }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>点数:{{ $list_content['points'] }}</div>
                                        </td>
                                        <td>
                                            <form>
                                                <input data-id="{{ $list_content['id'] }}" type="button"
                                                    class="btn btn-danger btn-dell delete_btn" value="削除">
                                            </form>
                                        </td>
                                        <td>
                                            <div>
                                                <button href="" data-bs-toggle="modal"
                                                    data-bs-target="#songEditModal-{{ $list_content['id'] }}"
                                                    class='btn btn-warning btn-dell'>編集</button>
                                            </div>
                                            {{-- 編集用モーダル --}}
                                            <div class="modal fade" id="songEditModal-{{ $list_content['id'] }}"
                                                tabindex="-1" aria-labelledby="songEditModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="songEditModalLabel">登録情報編集
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="songEditform"
                                                                action="{{ route('song.search', ['song_list' => $song_detail['id']]) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="song-point" class="col-form-label"
                                                                        required>点数</label>
                                                                    <input id="song-point" type="text"
                                                                        class="form-control" name="points"
                                                                        value="{{ $list_content['points'] }}">
                                                                    <label for="mp3_data"
                                                                        class="col-form-label">音声ファイル登録</label>
                                                                    <input id="comment" type="file"
                                                                        class="form-control" name="mp3_data"
                                                                        accept="audio/*">
                                                                    <label for="song-comment"
                                                                        class="col-form-label">コメント</label>
                                                                    <textarea id="song-comment" class="form-control" name="comment">{{ $list_content['comment'] }}</textarea>
                                                                    <button id="edit-button" type="button"
                                                                        class="btn btn-primary edit_btn"
                                                                        formaction="#">編集</button>
                                                                </div>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">閉じる</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- 編集用モーダルここまで --}}
                                        </td>
                                    </tr>
                                </div>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- 新規楽曲追加モーダルウィンドウ -->
            <a href="" data-bs-toggle="modal" data-bs-target="#listRegistModal">新規楽曲追加</a>
            <div class="modal fade" id="listRegistModal" tabindex="-1" aria-labelledby="listRegistModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="listRegistModalLabel">新規楽曲登録</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="songform" action="{{ route('song.search', ['song_list' => $song_detail['id']]) }}"
                                method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="song-name" class="col-form-label">曲検索</label>
                                    <input id="song-input" type="text" class="form-control" name="song_name"
                                        required>
                                    <button id="song-button" type="submit" class="btn btn-primary send-button"
                                        formaction="#">検索</button>
                                </div>
                            </form>
                            <form id="artistform" action="#" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="artist-name" class="col-form-label">アーティスト名検索</label>
                                    <input id="artist-input" type="text" class="form-control" name="artist-name"
                                        required>
                                    <button id="artist-button" type="submit" class="btn btn-primary send-button"
                                        formaction="#">検索</button>
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--モーダルウィンドウここまで-->
        </div>
    </div>
@endsection
