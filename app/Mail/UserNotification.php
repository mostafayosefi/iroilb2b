<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $action;
    public $lang;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($action, $lang)
    {
        if ($action == 'send') {
            $action = 'message';
        }
        $this->action = $action;
        $this->lang = $lang;
        if ($lang == 'fa') {
            $this->subject = 'پیام جدید از IR OIL B2B';
        } else {
            $this->subject = 'New message from IR OIL B2B';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('email.SendNotification')
            ->subject($this->subject);
    }
}
