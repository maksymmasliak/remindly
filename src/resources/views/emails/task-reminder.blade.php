<h2>⏰ Reminder: {{ $task->title }}</h2>

<p>Just a heads up — this task is coming up soon.</p>

<p><strong>Due:</strong> {{ $task->due_at->format('M d, Y — H:i') }}</p>

@if ($task->description)
    <p>{{ $task->description }}</p>
@endif

<p>— Remindly</p>
