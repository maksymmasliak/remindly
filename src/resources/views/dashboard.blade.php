@extends('layouts.app')

@section('content')
    <h1>Welcome back, {{ auth()->user()->name }}!</h1>

    <a href="{{ route('tasks.index') }}">View my tasks</a>

    @include('partials.logout-form')
@endsection
