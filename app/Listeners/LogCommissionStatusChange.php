<?php

namespace App\Listeners;

use App\Events\CommissionStatusChanged;
use Illuminate\Support\Facades\Log;

class LogCommissionStatusChange
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
    public function handle(CommissionStatusChanged $event): void
    {
        Log::info('Commission status changed', [
            'commission_id' => $event->commission->id,
            'old_status' => $event->oldStatus,
            'new_status' => $event->newStatus,
            'changed_by' => auth()->id(),
        ]);

        // In a real application, send email notification to client
        // if ($event->newStatus === 'completed') {
        //     Mail::to($event->commission->client_email)->send(
        //         new \App\Mail\CommissionCompleted($event->commission)
        //     );
        // }
    }
}
