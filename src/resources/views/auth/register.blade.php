@extends('layouts.app')

@section('content')
    <h1>Реєстрація</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Ім'я</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">

        <label for="password">Пароль</label>
        <input type="password" name="password" id="password">

        <label for="password_confirmation">Підтвердження пароля</label>
        <input type="password" name="password_confirmation" id="password_confirmation">

        <button type="submit">Зареєструватись</button>
        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </form>
@endsection
