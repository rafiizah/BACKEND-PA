<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $subject;
    protected $body;

    public function __construct($email, $subject, $body)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function handle()
    {
        Mail::send('emails.custom', ['subject' => $this->subject, 'body' => $this->body], function ($message) {
            $message->to($this->email)
                ->subject($this->subject);
        });
    }
}
