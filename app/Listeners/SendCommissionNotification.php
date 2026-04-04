<?php

namespace App\Listeners;

use App\Events\CommissionCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCommissionNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(CommissionCreated $event): void
    {
        $commission = $event->commission;

        // Log the commission creation
        Log::info('New commission request received', [
            'commission_id' => $commission->id,
            'client_name' => $commission->client_name,
            'client_email' => $commission->client_email,
            'character_type' => $commission->character_type,
            'budget' => $commission->budget,
        ]);

        // In a real application, send email notification to admin
        // Mail::to(config('mail.admin_email'))->send(
        //     new \App\Mail\NewCommissionNotification($commission)
        // );
    }
}
