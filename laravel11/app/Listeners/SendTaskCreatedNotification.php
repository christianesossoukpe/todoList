<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Mail\TaskCreated as MailTaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskCreated as TaskCreatedMail;
class SendTaskCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MailTaskCreated $event): void
    {
        Mail::to('recipient@example.com')->send(new TaskCreatedMail($event->task));
    }
}
