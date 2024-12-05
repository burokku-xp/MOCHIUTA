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
                        <div class="change-flg">
                            <tr scope="col" class="d-flex">
                                <td>
                                    <div>曲名：{{ $list_content['name'] }}</div>
                                    <div>アーティスト名：{{ $list_content['artist'] }}</div>
                                </td>
                                <td>
                                    <audio controlslist="nodownload" class="audio_list" controls
                                        src="{{ asset('storage/audio/' . $list_content['music_data_path']) }}"
                                        type="audio/*"></audio>
                                </td>
                                <td>
                                    <div class="point_list">点数:{{ $list_content['points'] }}</div>
                                </td>
                            </tr>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection