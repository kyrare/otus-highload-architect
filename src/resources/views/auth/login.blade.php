@extends('layouts.layout', [
    'title' => 'Авторизация'
])

@section('content')


    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <h1>Авторизация</h1>

            <form action="" method="post">
                @csrf

                <div class="form-group">
                    <label for="login">Логин</label>

                    <input id="login" class="form-control @error('login') is-invalid @enderror"
                           type="text" name="login" value="{{ old('login') }}"
                           required maxlength="255">

                    @error('login')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>

                    <input id="password" class="form-control @error('password') is-invalid @enderror"
                           type="password" name="password" value="{{ old('password') }}"
                           required minlength="8" maxlength="255">

                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @error('auth')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-between">
                    <a href="{{ route('register') }}" class="btn btn-secondary">Регистрация</a>
                    <button type="submit" class="btn btn-primary">Авторизоваться</button>
                </div>
            </form>
        </div>
    </div>
@endsection
