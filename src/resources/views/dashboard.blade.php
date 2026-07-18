@extends('layouts.app')

@section('topbar')
    @include('partials.logout-form')
@endsection

@section('content')
    <div class="page">
        <h1>Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="subtitle">Here's your task overview.</p>

        <a href="{{ route('tasks.index') }}" class="btn btn--primary">View my tasks</a>
    </div>
@endsection
