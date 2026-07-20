<?php

namespace App\Jobs;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail; // Assumes you have created a standard Mailable class

class SendBroadcastEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscriber;
    protected $messageContent;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscriber $subscriber, $messageContent)
    {
        $this->subscriber = $subscriber;
        $this->messageContent = $messageContent;
    }

    /**
     * Execute the job (This runs inside the background worker pipeline).
     */
    public function handle(): void
    {
        // Skip processing if the subscriber row was deleted while waiting in line
        if (!$this->subscriber) {
            return;
        }

        // Send the actual email out via your configured SMTP network provider
        Mail::to($this->subscriber->email)->send(new NewsletterMail($this->messageContent));
    }
}