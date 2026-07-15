@extends('layouts.app')

@section('content')
    <h1>Your tasks</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('tasks.create') }}">+ New task</a>

    @forelse ($tasks as $task)
        <div style="border: 1px solid #ddd; padding: 12px; margin: 8px 0; border-radius: 6px;">
            <strong>{{ $task->title }}</strong>
            <p>Due: {{ $task->due_at->format('Y-m-d H:i') }}</p>
            <p>Status: {{ $task->is_completed ? 'Completed' : 'Pending' }}</p>

            <a href="{{ route('tasks.show', $task) }}">View</a>
            <a href="{{ route('tasks.edit', $task) }}">Edit</a>

            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @empty
        <p>No tasks yet.</p>
    @endforelse

    @include('partials.logout-form')
@endsection
