<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $form;
    public $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$form)
    {
        $this->content = $content;
        $this->form = $form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from Osoule.com')
                    ->view('emails.'.$this->form);
    }
}
