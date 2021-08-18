<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenderMail extends Mailable implements ShouldQueue
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
        $date = Carbon::now()->isoFormat('MMM Do YYYY');
        return $this->subject('Hulum Tender alerts for '.$date)->markdown('emails.TenderMail')->with('tenders', $this->tinders);
    }
}
