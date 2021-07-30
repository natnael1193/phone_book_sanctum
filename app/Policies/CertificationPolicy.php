<?php

namespace App\Policies;

use App\Certification;
use App\Subscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Subscriber can view any models.
     *
     * @param  \App\Subscriber  $subscriber
     * @return mixed
     */
    public function viewAny(Subscriber $subscriber)
    {
        //
    }

    /**
     * Determine whether the Subscriber can view the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Certification  $certification
     * @return mixed
     */
    public function view(Subscriber $subscriber, Certification $certification)
    {
        //

    }

    /**
     * Determine whether the Subscriber can create models.
     *
     * @param  \App\Subscriber  $subscriber
     * @return mixed
     */
    public function create(Subscriber $subscriber)
    {
        //
    }

    /**
     * Determine whether the Subscriber can update the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Certification  $certification
     * @return mixed
     */
    public function update(Subscriber $subscriber, Certification $certification)
    {
        //
        return $subscriber->id === $certification->subscriber_id;
    }

    /**
     * Determine whether the Subscriber can delete the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Certification  $certification
     * @return mixed
     */
    public function delete(Subscriber $subscriber, Certification $certification)
    {
        //
    }

    /**
     * Determine whether the Subscriber can restore the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Certification  $certification
     * @return mixed
     */
    public function restore(Subscriber $subscriber, Certification $certification)
    {
        //
    }

    /**
     * Determine whether the Subscriber can permanently delete the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Certification  $certification
     * @return mixed
     */
    public function forceDelete(Subscriber $subscriber, Certification $certification)
    {
        //
    }
}
