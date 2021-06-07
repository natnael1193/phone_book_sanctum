<?php

namespace App\Policies;

use App\User;
use App\Service;
use App\Subscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
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
     * @param  \App\Service  $service
     * @return mixed
     */
    public function view( Subscriber $subscriber, Service $service)
    {
        //
        // $user = User::all();
        return in_array($subscriber->id, [
            $subscriber->id == $service->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
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
     * @param  \App\Service  $service
     * @return mixed
     */
    public function update(Subscriber $subscriber, Service $service)
    {
        //
        // $user = User::all();
        return in_array($subscriber->id, [
            $subscriber->id == $service->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the Subscriber can delete the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Service  $service
     * @return mixed
     */
    public function delete(Subscriber $subscriber, Service $service)
    {
        //
        // $user = User::all();
        return in_array($subscriber->id, [
            $subscriber->id == $service->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the Subscriber can restore the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Service  $service
     * @return mixed
     */
    public function restore(Subscriber $subscriber, Service $service)
    {
        //
    }

    /**
     * Determine whether the Subscriber can permanently delete the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Service  $service
     * @return mixed
     */
    public function forceDelete(Subscriber $subscriber, Service $service)
    {
        //
    }
}