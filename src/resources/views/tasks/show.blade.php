@extends('layouts.app')

@section('topbar')
    <a href="{{ route('tasks.index') }}" class="btn btn--secondary btn--sm">Back to list</a>
    @include('partials.logout-form')
@endsection

@section('content')
    <div class="page page--narrow">
        <div class="card">
            <div class="task-card__header">
                <h1 style="margin: 0;">{{ $task->title }}</h1>
                @if ($task->is_completed)
                    <span class="badge badge--completed">Completed</span>
                @else
                    <span class="badge badge--pending">Pending</span>
                @endif
            </div>

            <p class="task-card__meta">Due: {{ $task->due_at->format('M d, Y — H:i') }}</p>

            @if ($task->description)
                <p>{{ $task->description }}</p>
            @else
                <p class="subtitle">No description provided.</p>
            @endif

            <div class="btn-row">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn--primary">Edit</a>
                <a href="{{ route('tasks.index') }}" class="btn btn--secondary">Back to list</a>
            </div>
        </div>
    </div>
@endsection
