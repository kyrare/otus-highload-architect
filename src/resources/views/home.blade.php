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

    <h2>Домашнии задания на проверку</h2>
    <ul class="list-unstyled">
        <li><a href="{{ route('unit-2') }}">Производительность индеков</a></li>
    </ul>
@endsection
