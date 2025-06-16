<?php

namespace App\Listeners;

use App\Events\AdminPasswordChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminPasswordChangedNotificationMail;
use App\Models\Admin;

class SendAdminPasswordChangedNotification
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
    public function handle(AdminPasswordChanged $event): void
    {
        Mail::to($event->admin->email)->send(new AdminPasswordChangedNotificationMail($event->admin));
    }
}
