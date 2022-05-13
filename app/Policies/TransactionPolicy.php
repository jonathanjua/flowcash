<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transaction can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the transaction can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Transaction  $model
     * @return mixed
     */
    public function view(User $user, Transaction $model)
    {
        return true;
    }

    /**
     * Determine whether the transaction can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the transaction can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Transaction  $model
     * @return mixed
     */
    public function update(User $user, Transaction $model)
    {
        return true;
    }

    /**
     * Determine whether the transaction can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Transaction  $model
     * @return mixed
     */
    public function delete(User $user, Transaction $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Transaction  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the transaction can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Transaction  $model
     * @return mixed
     */
    public function restore(User $user, Transaction $model)
    {
        return false;
    }

    /**
     * Determine whether the transaction can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Transaction  $model
     * @return mixed
     */
    public function forceDelete(User $user, Transaction $model)
    {
        return false;
    }
}
