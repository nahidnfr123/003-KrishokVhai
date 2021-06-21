<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MySendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mail_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_details)
    {
        $this->mail_details = $mail_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('email.reply_mail');
        return $this->from('projects@nahidferdous.com')
            ->view('email.reply_mail')
            ->with('mail_details', $this->mail_details);
    }
}
