@extends('layouts.app')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Create account</h1>
            <p class="subtitle">Start organizing your tasks today.</p>

            @if ($errors->any())
                <div class="alert alert--errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="form">
                @csrf

                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" autofocus>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <button type="submit" class="btn btn--primary">Register</button>
            </form>

            <p class="auth-footer">Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
@endsection
