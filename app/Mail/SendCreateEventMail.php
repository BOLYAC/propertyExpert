<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCreateEventMail extends Mailable
{
    use Queueable, SerializesModels;

    protected array $emailData;

    /**
     * Create a new message instance.
     *
     * @param $emailData
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SendCreateEventMail
    {
        return $this->markdown('emails.create-event-mail')->with('data',$this->emailData);
    }
}
