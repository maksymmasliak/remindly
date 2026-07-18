@extends('layouts.app')

@section('topbar')
    <a href="{{ route('dashboard') }}" class="btn btn--secondary btn--sm">Dashboard</a>
    @include('partials.logout-form')
@endsection

@section('content')
    <div class="page">
        <h1>Your tasks</h1>
        <p class="subtitle">Everything you need to get done.</p>

        @if (session('success'))
            <div class="alert alert--success">{{ session('success') }}</div>
        @endif

        <div class="btn-row" style="margin-bottom: 24px;">
            <a href="{{ route('tasks.create') }}" class="btn btn--primary">+ New task</a>
        </div>

        <div class="task-list">
            @forelse ($tasks as $task)
                <div class="task-card">
                    <div class="task-card__header">
                        <h2 class="task-card__title">{{ $task->title }}</h2>
                        @if ($task->is_completed)
                            <span class="badge badge--completed">Completed</span>
                        @else
                            <span class="badge badge--pending">Pending</span>
                        @endif
                    </div>

                    <p class="task-card__meta">Due: {{ $task->due_at->format('M d, Y — H:i') }}</p>

                    <div class="task-card__actions">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn--secondary btn--sm">View</a>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn--secondary btn--sm">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--danger btn--sm">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>No tasks yet. Create your first one to get started.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
