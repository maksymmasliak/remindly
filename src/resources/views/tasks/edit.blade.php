@extends('layouts.app')

@section('content')
    <h1>Edit task</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}">

        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $task->description) }}</textarea>

        <label for="due_at">Due date</label>
        <input type="datetime-local" name="due_at" id="due_at" value="{{ old('due_at', $task->due_at->format('Y-m-d\TH:i')) }}">

        <label for="is_completed">
            <input type="checkbox" name="is_completed" id="is_completed" value="1" {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}>
            Completed
        </label>

        <button type="submit">Save changes</button>
    </form>

    <a href="{{ route('tasks.index') }}">Back to list</a>
@endsection
