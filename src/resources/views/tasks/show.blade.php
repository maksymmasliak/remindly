@extends('layouts.app')

@section('content')
    <h1>{{ $task->title }}</h1>

    <p>{{ $task->description ?? 'No description' }}</p>
    <p>Due: {{ $task->due_at->format('Y-m-d H:i') }}</p>
    <p>Status: {{ $task->is_completed ? 'Completed' : 'Pending' }}</p>

    <a href="{{ route('tasks.edit', $task) }}">Edit</a>
    <a href="{{ route('tasks.index') }}">Back to list</a>
@endsection
