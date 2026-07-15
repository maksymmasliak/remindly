@extends('layouts.app')

@section('content')
    <h1>Remindly</h1>

    <p>Task management with automated email reminders.</p>

    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
@endsection
