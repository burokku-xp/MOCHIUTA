@extends('layouts.header')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <table class="change-flg table align-middle">
                            <thead>
                                <th scope="col" class="d-none d-md-table-cell"></th>
                                <th scope="col">タイトル</th>
                                <th scope="col">アーティスト</th>
                                <th scope="col">点数</th>
                                <th scope="col" class="d-none d-md-table-cell">音声ファイル</th>
                            </thead>
                            @foreach ($list_contents as $list_content)
                                <tbody>
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
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
