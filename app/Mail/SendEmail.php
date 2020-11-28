<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->details['to_email'], $this->details['to_name'])
                    ->from(config('email.all-users.from_email'), config('email.all-users.from_name'))
                    ->subject(config('email.all-users.subject'))
                    ->view('emails.test');
    }
}
