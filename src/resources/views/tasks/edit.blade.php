@extends('layouts.app')

@section('topbar')
    <a href="{{ route('tasks.index') }}" class="btn btn--secondary btn--sm">Back to list</a>
    @include('partials.logout-form')
@endsection

@section('content')
    <div class="page page--narrow">
        <h1>Edit task</h1>
        <p class="subtitle">Update the details below.</p>

        @if ($errors->any())
            <div class="alert alert--errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="form">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}">
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea name="description" id="description">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="field">
                    <label for="due_at">Due date</label>
                    <input type="datetime-local" name="due_at" id="due_at" value="{{ old('due_at', $task->due_at->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="field field-checkbox">
                    <input type="checkbox" name="is_completed" id="is_completed" value="1" {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}>
                    <label for="is_completed">Mark as completed</label>
                </div>

                <button type="submit" class="btn btn--primary">Save changes</button>
            </form>
        </div>
    </div>
@endsection
