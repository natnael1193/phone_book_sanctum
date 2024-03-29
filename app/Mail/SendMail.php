<?php

namespace App\Mail;

use App\Tinder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tinders;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tinder)
    {
        $this->tinders = $tinder;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome Email')->markdown('emails.TestMail')->with('tenders', $this->tinders);
    }
}
