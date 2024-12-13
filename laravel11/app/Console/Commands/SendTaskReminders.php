<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_date', '<=', now()->addDays(2))
                     ->where('due_date', '>', now())
                     ->get();
    
        foreach ($tasks as $task) {
            $task->user->notify(new TaskReminder($task));
        }
    }
}