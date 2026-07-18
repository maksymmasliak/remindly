@extends('layouts.app')

@section('topbar')
    <a href="{{ route('tasks.index') }}" class="btn btn--secondary btn--sm">Back to list</a>
    @include('partials.logout-form')
@endsection

@section('content')
    <div class="page page--narrow">
        <h1>New task</h1>
        <p class="subtitle">Add something to your list.</p>

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
            <form method="POST" action="{{ route('tasks.store') }}" class="form">
                @csrf

                <div class="field">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" autofocus>
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea name="description" id="description">{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label for="due_at">Due date</label>
                    <input type="datetime-local" name="due_at" id="due_at" value="{{ old('due_at') }}">
                </div>

                <button type="submit" class="btn btn--primary">Create task</button>
            </form>
        </div>
    </div>
@endsection
