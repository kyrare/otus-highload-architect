@extends('layouts.layout', [
    'title' => 'Главная'
])

@section('content')
    <ul class="list-unstyled">
        <li><a href="{{ route('login') }}">Авторизация</a></li>
        <li><a href="{{ route('register') }}">Регистрация</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
        <li><a href="{{ route('users') }}">Пользователи</a></li>
    </ul>
@endsection
