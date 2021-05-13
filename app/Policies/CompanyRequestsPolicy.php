<?php

namespace App\Policies;

use App\CompanyRequests;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class CompanyRequestsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return in_array($user->email, [
            'natnaelsolomon770@gmail.com',
            'jak@gmail.com',
         
            // $user->role == 1,
            // $user->status_id == 1,
            // $user->role == 1,
            $user->role == 4,
        ],         
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyRequests  $companyRequests
     * @return mixed
     */
    public function view(User $user, CompanyRequests $companyRequests)
    {
        //
       return $user->role = 1;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyRequests  $companyRequests
     * @return mixed
     */
    public function update(User $user, CompanyRequests $companyRequests)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyRequests  $companyRequests
     * @return mixed
     */
    public function delete(User $user, CompanyRequests $companyRequests)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyRequests  $companyRequests
     * @return mixed
     */
    public function restore(User $user, CompanyRequests $companyRequests)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyRequests  $companyRequests
     * @return mixed
     */
    public function forceDelete(User $user, CompanyRequests $companyRequests)
    {
        //
    }
}