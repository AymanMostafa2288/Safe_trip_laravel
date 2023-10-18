<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
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

        // return $this->subject("Mail from Osoule")->view('emails.frontend.forget_password');
        // return $this->markdown('emails.frontend.forget_password',['details'=>$this->details]);

        return $this->subject('Mail from Osoule.com')
                    ->view('emails.frontend.forget_password');
        // return $this->view('view.name');
    }
}
