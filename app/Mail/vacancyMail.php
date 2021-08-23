<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class vacancyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vacancies;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vacancies)
    {
        $this->vacancies = $vacancies;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        $date = Carbon::now()->isoFormat('MMM Do YYYY');
        return $this->subject('Hulum Vacancy alerts for '.$date)->markdown('emails.vacncyMail')->with('vacancies', $this->vacancies);
    }
}
