<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $lang;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code , $lang)
    {
        $this->code = $code;
        $this->lang = $lang;
        if ($this->lang=='fa'){
            $this->subject='کد تایید IR Oil B2B: ';
        }else{
            $this->subject='IR Oil B2B verification code: ';
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
            ->view('email.SendCode')
            ->subject($this->subject . $this->code);
    }
}
