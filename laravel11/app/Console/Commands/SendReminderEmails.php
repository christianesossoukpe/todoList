<?php

namespace App\Console\Commands;

use App\Mail\TaskReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Task; // Assurez-vous d'importer votre modèle de tâche

class SendReminderEmails extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminder emails for tasks due in less than 2 days';

    public function handle()
    {
        $tasks = Task::where('due_date', '<=', now()->addDays(2))
                     ->where('reminder_sent', false)
                     ->get();

        foreach ($tasks as $task) {
            Mail::to($task->user->email)->send(new TaskReminder($task));

            $task->reminder_sent = true;
            $task->save();
        }

        $this->info('Reminder emails sent successfully!');
    }
}
