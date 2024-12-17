@foreach ($favorite_users as $favorite_user)
<tr>
    <th scope="col">
        <div class="btn-group dropend">
            <a href="" class="dropdown-toggle" data-bs-toggle="dropdown">
                {{ $favorite_user['user_name'] }}
            </a>
            <ul class="dropdown-menu">
                @foreach ($favorite_user['list_content'] as $list)
                    <div>
                        <a href="{{ route('search.list', ['song_list' => $list['list_id']]) }}">
                            {{ $list['list_name'] }}
                        </a>
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
