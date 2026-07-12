<?php

namespace App\Console\Commands;

use App\Mail\PromiseReminderMail;
use App\Models\Promise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReminders extends Command
{
    protected $signature   = 'reminders:send';
    protected $description = 'Send scheduled promise reminders to users.';

    public function handle(): int
    {
        $due = Promise::query()
            ->whereNotNull('email')
            ->whereNotNull('remind_at')
            ->whereNull('reminder_sent_at')
            ->where('remind_at', '<=', now())
            ->get();

        if ($due->isEmpty()) {
            $this->info('No reminders due.');
            return self::SUCCESS;
        }

        $sent   = 0;
        $failed = 0;

        foreach ($due as $promise) {
            try {
                Mail::to($promise->email)->send(new PromiseReminderMail($promise));

                $promise->update(['reminder_sent_at' => now()]);

                $sent++;
                $this->info("Reminder sent: {$promise->uuid}");
            } catch (\Exception $e) {
                $failed++;
                Log::error("Reminder failed for promise {$promise->uuid}: " . $e->getMessage());
                $this->error("Failed: {$promise->uuid}");
            }
        }

        $this->info("Done. Sent: {$sent}, Failed: {$failed}.");

        return self::SUCCESS;
    }
}
