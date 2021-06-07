<?php

namespace App\Policies;

use App\Subscriber;
use App\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
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
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function view(Subscriber $subscriber, Vacancy $vacancy)
    {
        //
           // $user = User::all();
           return in_array($subscriber->id, [
            $subscriber->id == $vacancy->subscriber_id,
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
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function update(Subscriber $subscriber, Vacancy $vacancy)
    {
               // $user = User::all();
               return in_array($subscriber->id, [
                $subscriber->id == $vacancy->subscriber_id,
                // $user->role = 4,
                // $user->role = 1,
                ]
                );
    }

    /**
     * Determine whether the Subscriber can delete the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(Subscriber $subscriber, Vacancy $vacancy)
    {
             // $user = User::all();
             return in_array($subscriber->id, [
                $subscriber->id == $vacancy->subscriber_id,
                // $user->role = 4,
                // $user->role = 1,
                ]
                );
    }

    /**
     * Determine whether the Subscriber can restore the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function restore(Subscriber $subscriber, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the Subscriber can permanently delete the model.
     *
     * @param  \App\Subscriber  $subscriber
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function forceDelete(Subscriber $subscriber, Vacancy $vacancy)
    {
        //
    }
}