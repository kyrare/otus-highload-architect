@extends('layouts.layout', [
    'title' => $search ? 'Поиск пользователя' : 'Список пользователей'
])

@section('content')

    <h1>Пользователи</h1>

    <form>
        <div class="form-group">
            <input id="users-search"
                   class="form-control"
                   type="text" name="q" value="{{ $search }}"
                   placeholder="Поиск пользователей">
        </div>
    </form>

    <ul class="list-unstyled">
        @foreach($users as $user)
            <li>
                <a href="{{ route('users-show', $user['id']) }}">
                    {{ $user['name'] . ' ' . $user['surname'] }}
                </a>
            </li>
        @endforeach
    </ul>

@endsection
