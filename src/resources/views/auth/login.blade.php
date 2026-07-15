@extends('layouts.app')

@section('content')
    <h1>Вхід</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">

        <label for="password">Пароль</label>
        <input type="password" name="password" id="password">

        <button type="submit">Увійти</button>
        <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </form>
@endsection
