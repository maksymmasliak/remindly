<h2>Task reminder</h2>

<p>Your task "{{ $task->title }}" is due soon.</p>

<p>Due date: {{ $task->due_at->format('Y-m-d H:i') }}</p>

@if ($task->description)
    <p>{{ $task->description }}</p>
@endif
