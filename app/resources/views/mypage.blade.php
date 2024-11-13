@extends('layouts.app')
@section('content')
<a href="#" id="logout" class="mt-navbar-item">ログアウト</a>
<form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
    @csrf
</form>
<script>
    document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });
</script>
@endsection