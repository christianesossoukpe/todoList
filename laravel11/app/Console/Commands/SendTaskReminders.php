<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send task reminder emails';

     public function __construct()
      { 
        parent::__construct(); 
    }
    public function handle()
    {
        $tasks = Task::where('due_date', '<=', Carbon::now()->addDays(2)) 
         ->where('reminder_sent', false)
         ->get();
         foreach ($tasks as $task) {
             $task->user->notify(new TaskReminderNotification($task));
              $task->reminder_sent = true; $task->save();
         }
     }
}
