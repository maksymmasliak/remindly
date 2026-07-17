<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskReminderMail;
use App\Models\Task;

class SendTaskReminderJob implements ShouldQueue
{
    use Queueable;
    public int $tries = 3;
    /**
     * Create a new job instance.
     */
    public function __construct(public Task $task)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Mail::to($this->task->user->email)->send(new TaskReminderMail($this->task));

        $this->task->update(['reminder_sent_at' => now()]);
    }

}
