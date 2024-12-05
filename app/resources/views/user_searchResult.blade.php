@extends('layouts.header')
@section('content')
<div class="container">
    <h1 class='text-center'>ユーザー 一覧</h1>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        @foreach ($user_searchs as $user_search)
                        <table>
                            <tr scope="col" class="d-flex">
                                <td>
                                    <div>{{ $user_search['user_name'] }}<></div>
                                    @foreach ($user_search['list_content'] as $list_content)
                                    <li><a href="{{ route('search.list', ['song_list' => $list_content['list_id']])}}">{{ $list_content['list_name'] }}</a></li>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection