<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskReminderNotification extends Notification
{
    use Queueable;
    private $task;
    /**
     * Create a new notification instance.
     */
    public function __construct($task) { 
        $this->task = $task;
     }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable) {
         return ['mail'];
         }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable) { 
        return (new MailMessage)
         ->line('This is a reminder for the task: '.$this->task->name) ->action('View Task', url('/tasks/'.$this->task->id)) ->line('Please complete it before the deadline: '.$this->task->due_date);
     }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
