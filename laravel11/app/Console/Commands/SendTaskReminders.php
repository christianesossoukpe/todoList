<?php

namespace App\Console\Commands;
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Envoie des rappels par email pour les tâches qui expirent dans 2 jours.';

    public function handle()
    {
        // Récupérer les tâches avec une date d'expiration dans les 2 jours
        $tasks = Task::whereDate('due_date', '=', now()->addDays(2)->toDateString())->get();

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                // Mail::to($task->user->email)->send(new \App\Mail\TaskReminder($task));
                Mail::to($task->user->email)->queue(new \App\Mail\TaskReminder($task));

            }
        }

        $this->info('Rappels envoyés avec succès.');
    }
}
