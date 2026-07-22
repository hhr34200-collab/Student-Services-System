<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NotificationMail extends Mailable
{
    public $title;
    public $messageText;

    public function __construct(
        $title,
        $messageText
    ) {
        $this->title = $title;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->subject($this->title)
                    ->view('emails.notification');
    }
}