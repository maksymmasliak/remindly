@extends('layouts.app')

@section('content')
    <div class="hero">
        <h1>Remindly</h1>
        <p>Task management with automated email reminders, sent 15 minutes before due time.</p>
        <div class="btn-row">
            <a href="{{ route('login') }}" class="btn btn--primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn--secondary">Register</a>
        </div>
    </div>
@endsection
