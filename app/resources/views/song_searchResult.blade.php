@extends('layouts.header')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body center-block">
                        @foreach ($song_searchs as $song_search)
                            <a href="" data-bs-toggle="modal" data-bs-target="#{{ $song_search['track_id'] }}">
                                <p>{{ $song_search['name'] }}</p>
                            </a>
                            <p>{{ $song_search['artist'] }}</p>
                            <iframe style="border-radius:12px"
                                src="https://open.spotify.com/embed/track/{{ $song_search['track_id'] }}?utm_source=generator"
                                width="100%" height="80" frameBorder="0" allowfullscreen=""
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                            <!-- モーダルウィンドウ -->
                            <div class="modal fade search_form" id="{{ $song_search['track_id'] }}" tabindex="-1"
                                aria-labelledby="listRegistModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="listRegistModalLabel">新規楽曲登録</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="searchform" action="{{ route('song.regist', ['song_list' => $id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <p>{{ $song_search['name'] }}</p>
                                                    <p>{{ $song_search['artist'] }}</p>
                                                    <input type="hidden" name="name" value="{{ $song_search['name'] }}">
                                                    <input type="hidden" name="artist"
                                                        value="{{ $song_search['artist'] }}">
                                                    <input type="hidden" name="jacket"
                                                        value="{{ $song_search['jacket'] }}">
                                                    <label for="song-point" class="col-form-label" required>点数</label>
                                                    <input id="song-input" type="number" min="0" max="100"
                                                        oninput="javascript: this.value = this.value.slice(0, 3);"
                                                        class="form-control" name="points" required>
                                                    <label for="mp3_data" class="col-form-label">音声ファイル登録</label>
                                                    <input id="comment" type="file" class="form-control"
                                                        name="mp3_data" accept="audio/*">
                                                    <label for="song-comment" class="col-form-label">コメント</label>
                                                    <textarea id="song-comment" class="form-control" name="comment"></textarea>
                                                    <button type="submit" class="btn btn-primary send_button">登録</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--モーダルウィンドウここまで-->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
