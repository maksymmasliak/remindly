@extends('layouts.app')

@section('content')
    <h1>Welcome back, {{ auth()->user()->name }}!</h1>

    <p>Your task list will appear here.</p>

    @include('partials.logout-form')
@endsection
