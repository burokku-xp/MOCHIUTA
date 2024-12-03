@extends('layouts.header')
@section('content')
    <div class="container">
        <h1 class='text-center'>一覧</h1>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            @foreach ($tests as $test)
                                <p>曲名</p>
                                <a>
                                    <li><?php var_dump($test); ?></li>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
