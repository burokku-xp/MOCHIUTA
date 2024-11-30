@extends('layouts.header')
@section('content')

<div class="container">
    <h1 class='text-center'>一覧</h1>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        @foreach($song_searchs as $song_search)
                        <p>曲名</p>
                        <a>
                            <li>{{$song_search["name"]}} </li>
                        </a>
                        <p>アーティスト名</p>
                        <li>{{$song_search["artist"]}}</li>
                        <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/{{$song_search["track_id"]}}?utm_source=generator" width="100%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection