@extends('layouts.layout', [
    'title' => $user['name'] . ' ' . $user['surname']
])

@section('content')

    <h1>Пользователи</h1>

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
