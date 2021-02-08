@extends('layouts.layout', [
    'title' => $user['name'] . ' ' . $user['surname']
])

@section('content')

    <div class="row">
        <div class="col-4">
            <img class="img-thumbnail mb-2 w-100"
                 src="http://placehold.it/200x200?text={{ $user['name'] . ' ' . $user['surname'] }}"
                 alt="{{ $user['name'] . ' ' . $user['surname'] }}"
                 title="{{ $user['name'] . ' ' . $user['surname'] }}"
                 width="200"
                 height="200">

            @if($friends)
                <h3>Друзья</h3>

                <div class="row mb-2">
                    @foreach($friends as $friend)
                        <div class="col-2 mb-1">
                            <a href="{{ route('users-show', $friend['id']) }}">
                                <img class="img-thumbnail d-block w-100"
                                     src="http://placehold.it/40x40?text={{ $friend['name'] . ' ' . $friend['surname'] }}"
                                     alt="{{ $friend['name'] . ' ' . $friend['surname'] }}"
                                     title="{{ $friend['name'] . ' ' . $friend['surname'] }}"
                                     width="40"
                                     height="40">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($mutualFriends)
                <h3>Общие друзья</h3>

                <div class="row">
                    @foreach($mutualFriends as $friend)
                        <div class="col-2 mb-2">
                            <a href="{{ route('users-show', $friend['id']) }}">
                                <img class="img-thumbnail d-block w-100"
                                     src="http://placehold.it/40x40?text={{ $friend['name'] . ' ' . $friend['surname'] }}"
                                     alt="{{ $friend['name'] . ' ' . $friend['surname'] }}"
                                     title="{{ $friend['name'] . ' ' . $friend['surname'] }}"
                                     width="40"
                                     height="40">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-8">
            <h1>
                {{ $user['name'] . ' ' . $user['surname'] }}

                @if(\App\Models\User::getCurrentId() == $user['id'])
                    (Вы)
                @endif
            </h1>

            <h2>Инфо:</h2>
            <ul>
                <li>
                    <b>Возраст:</b> {{ \Carbon\Carbon::parse($user['birthday'])->age }} лет
                </li>
                <li>
                    <b>Пол:</b> {{ $user['sex'] == \App\Models\User::SEX_MALE ? 'Мужской' : 'Женский' }}
                </li>
                <li>
                    <b>Город:</b> {{ $user['city'] }}
                </li>
            </ul>

            @if($interests)
                <h2>Интересы:</h2>
                <ul>
                    @foreach($interests as $interest)
                        <li>{{ $interest['name'] }}</li>
                    @endforeach
                </ul>
            @endif

            @if($canAddToFriends)
                <form action="{{ route('users-add-friend', $user['id']) }}" method="post">
                    @csrf

                    <button class="btn btn-primary @error('users-add-friend') is-invalid @enderror">
                        Добавить в друзья
                    </button>

                    @error('users-add-friend')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </form>
            @elseif($inFriends)
                @if(session('users-add-friend-success'))
                    <h3>Вы успешно добавили {{ $user['name'] . ' ' . $user['surname'] }} в друзья!</h3>
                @else
                    <h3>Вы друзья!</h3>
                @endif
            @endif
        </div>
    </div>

@endsection
