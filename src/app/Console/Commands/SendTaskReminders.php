<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Task;
use App\Jobs\SendTaskReminderJob;


#[Signature('app:send-task-reminders')]
#[Description('Send email reminders for tasks due within 15 minutes')]
class SendTaskReminders extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_at', '>=', now())
            ->where('due_at', '<=', now()->addMinutes(15))
            ->whereNull('reminder_sent_at')
            ->where('is_completed', false)
            ->get();

        foreach ($tasks as $task) {
            SendTaskReminderJob::dispatch($task);
        }

        $this->info("Successfully queued tasks: {$tasks->count()}");

    }
}
