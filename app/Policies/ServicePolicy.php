<?php

namespace App\Policies;

use App\User;
use App\Service;
use App\CompanyOwner;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the CompanyOwner can view any models.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @return mixed
     */
    public function viewAny(CompanyOwner $company_owner)
    {
        //
    }

    /**
     * Determine whether the CompanyOwner can view the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Service  $service
     * @return mixed
     */
    public function view(CompanyOwner $company_owner, Service $service)
    {
        //
        // $user = User::all();
        return in_array($company_owner->id, [
            $company_owner->id == $service->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the CompanyOwner can create models.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @return mixed
     */
    public function create(CompanyOwner $company_owner)
    {
        //
    }

    /**
     * Determine whether the CompanyOwner can update the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Service  $service
     * @return mixed
     */
    public function update(CompanyOwner $company_owner, Service $service)
    {
        //
        return in_array($company_owner->id, [
            $company_owner->id == $service->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the CompanyOwner can delete the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Service  $service
     * @return mixed
     */
    public function delete(CompanyOwner $company_owner, Service $service)
    {
        //
        return in_array($company_owner->id, [
            $company_owner->id == $service->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the CompanyOwner can restore the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Service  $service
     * @return mixed
     */
    public function restore(CompanyOwner $company_owner, Service $service)
    {
        //
    }

    /**
     * Determine whether the CompanyOwner can permanently delete the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Service  $service
     * @return mixed
     */
    public function forceDelete(CompanyOwner $company_owner, Service $service)
    {
        //
    }
}