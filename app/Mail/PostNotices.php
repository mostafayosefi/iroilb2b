<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostNotices extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $lang;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lang, $post)
    {
        $this->post = $post;
        $this->lang = $lang;
        if ($lang == 'fa') {
            $this->subject = $post['title'] . ' IR OIL B2B | پورتال نفت گاز پتروشیمی ';
        } else {
            $this->subject = $post['title'] . ' IR OIL B2B ';;
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
            ->view('email.PostNotices')
            ->subject($this->subject);
    }
}
