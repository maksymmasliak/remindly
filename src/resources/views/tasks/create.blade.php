@extends('layouts.app')

@section('content')
    <h1>New task</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">

        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>

        <label for="due_at">Due date</label>
        <input type="datetime-local" name="due_at" id="due_at" value="{{ old('due_at') }}">

        <button type="submit">Create task</button>
    </form>

    <a href="{{ route('tasks.index') }}">Back to list</a>
@endsection
