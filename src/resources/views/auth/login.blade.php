@extends('layouts.app')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Welcome back</h1>
            <p class="subtitle">Log in to manage your tasks.</p>

            @if ($errors->any())
                <div class="alert alert--errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="form">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <button type="submit" class="btn btn--primary">Login</button>
            </form>

            <p class="auth-footer">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
        </div>
    </div>
@endsection
