@extends('layouts.header')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <!--<table> 見た目整えるときdivのクラスをtableに付け替える-->
                        <table class="table align-middle">
                            <thead>
                                <th scope="col" class="d-none d-md-table-cell"></th>
                                <th scope="col">タイトル</th>
                                <th scope="col">アーティスト</th>
                                <th scope="col">点数</th>
                                <th scope="col" class="d-none d-md-table-cell">音声ファイル</th>
                                <th scope="col">
                                    <!-- 新規楽曲追加モーダルウィンドウ -->
                                    <a href="" data-bs-toggle="modal" data-bs-target="#listRegistModal">新規楽曲追加</a>
                                    <div class="modal fade" id="listRegistModal" tabindex="-1"
                                        aria-labelledby="listRegistModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="listRegistModalLabel">新規楽曲登録</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="songform"
                                                        action="{{ route('song.search', ['song_list' => $song_detail['id']]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="song-name" class="col-form-label">曲名検索</label>
                                                            <input id="song-input" type="text" class="form-control"
                                                                name="song_name" required>
                                                            <button id="song-button" type="submit"
                                                                class="btn btn-primary send-button"
                                                                formaction="#">検索</button>
                                                        </div>
                                                    </form>
                                                    <form id="artistform"
                                                        action="{{ route('artist.search', ['song_list' => $song_detail['id']]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="artist-name"
                                                                class="col-form-label">アーティスト名検索</label>
                                                            <input id="artist-input" type="text" class="form-control"
                                                                name="artist_name" required>
                                                            <button id="artist-button" type="submit"
                                                                class="btn btn-primary send-button"
                                                                formaction="#">検索</button>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">閉じる</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--モーダルウィンドウここまで-->
                                </th>
                            </thead>
                            @foreach ($list_contents as $list_content)
                                <tbody class="change-flg">
                                    <tr>
                                        <td class="d-none d-md-table-cell"><img src="{{ $list_content['path'] }}"
                                                style=" width:5rem; height:5rem;" class="img-thumbnail"></td>
                                        <td>
                                            <div>{{ $list_content['name'] }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $list_content['artist'] }}</div>
                                        </td>
                                        <td>
                                            <div class="point_list">{{ $list_content['points'] }}
                                            </div>
                                        </td>
                                        <td>
                                            <audio controlslist="nodownload" class="audio_list d-none d-md-table-cell"
                                                controls
                                                src="{{ asset('storage/audio/' . $list_content['music_data_path']) }}"
                                                type="audio/*"></audio>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                <button id="comment-button-{{ $list_content['id'] }}"
                                                    class="btn btn-primary btn-comment" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseExample-{{ $list_content['id'] }}"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    <div class="text-comment text-nowrap">コメントを開く</div>
                                                </button>
                                                <form>
                                                    <input data-id="{{ $list_content['id'] }}" type="button"
                                                        class="btn btn-danger btn-dell delete_btn text-nowrap"
                                                        value="削除">
                                                </form>
                                                <div>
                                                    <button href="" data-bs-toggle="modal"
                                                        data-bs-target="#songEditModal-{{ $list_content['id'] }}"
                                                        class='btn btn-warning btn-dell text-nowrap'>編集</button>
                                                </div>
                                                {{-- 編集用モーダル --}}
                                                <div class="modal fade" id="songEditModal-{{ $list_content['id'] }}"
                                                    tabindex="-1" aria-labelledby="songEditModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="songEditModalLabel">
                                                                    登録情報編集
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="songEditform"
                                                                    action="{{ route('song.search', ['song_list' => $song_detail['id']]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="song-point" class="col-form-label"
                                                                            required>点数</label>
                                                                        <input id="song-point" type="number"
                                                                            min="0" max="100"
                                                                            oninput="javascript: this.value = this.value.slice(0, 3);"
                                                                            class="form-control" name="points"
                                                                            value="{{ $list_content['points'] }}"
                                                                            required>
                                                                        <label for="mp3_data"
                                                                            class="col-form-label">音声ファイル登録</label>
                                                                        <input id="audio" type="file"
                                                                            class="form-control" name="mp3_data"
                                                                            accept="audio/*">
                                                                        <label for="song-comment"
                                                                            class="col-form-label">コメント</label>
                                                                        <textarea id="song-comment" class="form-control" name="comment">{{ $list_content['comment'] }}</textarea>
                                                                        <button id="edit-button" type="submit"
                                                                            data-id="{{ $list_content['id'] }}"
                                                                            class="btn btn-primary edit_btn"
                                                                            formaction="#">編集
                                                                            <div id="load-edit"
                                                                                class="spinner-border d-none"
                                                                                role="status"
                                                                                style="width: 1rem; height: 1rem;">
                                                                            </div>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">閉じる</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- 編集用モーダルここまで --}}
                                            </div>
                                            <div class="collapse overflow-auto"
                                                id="collapseExample-{{ $list_content['id'] }}" style="width:20vw;">
                                                <div class="card card-body comment_list">
                                                    {{ $list_content['comment'] }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                        <form id="form" class="list_delete"
                            action="{{ route('list.delete', ['song_list' => $song_detail['id']]) }}" method="post">
                            @csrf
                            <button type="button" class="btn btn-danger btn-dell listdelete">リストを削除</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
