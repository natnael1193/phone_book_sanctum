<?php

namespace App\Policies;

use App\CompanyOwner;
use App\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
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
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function view(CompanyOwner $company_owner, Vacancy $vacancy)
    {
        //
        return in_array($company_owner->id, [
            $company_owner->id == $vacancy->subscriber_id,
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
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function update(CompanyOwner $company_owner, Vacancy $vacancy)
    {
        //
        return in_array($company_owner->id, [
            $company_owner->id == $vacancy->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the CompanyOwner can delete the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(CompanyOwner $company_owner, Vacancy $vacancy)
    {
        //
        return in_array($company_owner->id, [
            $company_owner->id == $vacancy->subscriber_id,
            // $user->role = 4,
            // $user->role = 1,
            ]
            );
    }

    /**
     * Determine whether the CompanyOwner can restore the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function restore(CompanyOwner $company_owner, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the CompanyOwner can permanently delete the model.
     *
     * @param  \App\CompanyOwner  $company_owner
     * @param  \App\Vacancy  $vacancy
     * @return mixed
     */
    public function forceDelete(CompanyOwner $company_owner, Vacancy $vacancy)
    {
        //
    }
}
