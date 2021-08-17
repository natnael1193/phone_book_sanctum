<?php

namespace App\Observers;

use App\CompanyOwner;
use App\Mail\SendMail;
use App\Tinder;
use Illuminate\Support\Facades\Mail;

class TenderObserver
{
    /**
     * Handle the tinder "created" event.
     *
     * @param  \App\Tinder  $tinder
     * @return void
     */
    public function created(Tinder $tinder)
    {
        $details = [
            'title' => 'Mail from Larave Email',
            'body' => 'This email is intended to a customer to notify the on our up coming products.'
        ];

        $user = CompanyOwner ::findOrFail(16);
        // foreach ($users as $user) {
            Mail::to('yamlak.k@gmail.com')->send(new SendMail($details));
        // }
    }

    /**
     * Handle the tinder "updated" event.
     *
     * @param  \App\Tinder  $tinder
     * @return void
     */
    public function updated(Tinder $tinder)
    {
        //
    }

    /**
     * Handle the tinder "deleted" event.
     *
     * @param  \App\Tinder  $tinder
     * @return void
     */
    public function deleted(Tinder $tinder)
    {
        //
    }

    /**
     * Handle the tinder "restored" event.
     *
     * @param  \App\Tinder  $tinder
     * @return void
     */
    public function restored(Tinder $tinder)
    {
        //
    }

    /**
     * Handle the tinder "force deleted" event.
     *
     * @param  \App\Tinder  $tinder
     * @return void
     */
    public function forceDeleted(Tinder $tinder)
    {
        //
    }
}
