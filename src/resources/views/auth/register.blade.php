@extends('layouts.layout', [
    'title' => 'Регистрация'
])

@section('content')

    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <h1>Регистрация</h1>

            <form method="post">
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

                <div class="form-group">
                    <label for="password-confirmation">Повторить пароль</label>

                    <input id="password-confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                           type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                           required minlength="8" maxlength="255">

                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <div class="form-group">
                    <label for="name">Имя</label>

                    <input id="name" class="form-control @error('name') is-invalid @enderror"
                           type="text" name="name" value="{{ old('name') }}"
                           required maxlength="255">

                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="surname">Фамилия</label>

                    <input id="surname" class="form-control @error('surname') is-invalid @enderror"
                           type="text" name="surname" value="{{ old('surname') }}"
                           required maxlength="255">

                    @error('surname')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="birthday">Дата рождения</label>

                    <input id="birthday" class="form-control @error('birthday') is-invalid @enderror"
                           type="date" name="birthday" value="{{ old('birthday') }}"
                           required>

                    @error('birthday')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    Пол

                    <div class="form-check">
                        <input id="sex-m" class="form-check-input @error('sex') is-invalid @enderror"
                               type="radio" name="sex" value="{{ \App\Models\User::SEX_MALE }}" checked>
                        <label for="sex-m" class="form-check-label">Мужской</label>
                    </div>

                    <div class="form-check">
                        <input id="sex-f" class="form-check-input @error('sex') is-invalid @enderror"
                               type="radio" name="sex" value="{{ \App\Models\User::SEX_FEMALE }}">
                        <label for="sex-f" class="form-check-label">Женский</label>

                        @error('sex')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="interests">Интересы</label>

                    <select id="interests" class="form-control @error('interests') is-invalid @enderror" name="interests[]" required multiple>

                        @foreach($interests as $interest)
                            <option value="{{ $interest['id'] }}"
                                    @if(in_array($interest['id'], old('interests') ?? [])) selected @endif>
                                {{ $interest['name'] }}
                            </option>
                        @endforeach

                    </select>

                    @error('interests')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city">Город</label>

                    <input id="city" class="form-control @error('city') is-invalid @enderror"
                           type="text" name="city" value="{{ old('city') }}"
                           required>

                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('login') }}" class="btn btn-secondary">Авторизоваться</a>
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
@endsection
