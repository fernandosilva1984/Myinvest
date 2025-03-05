<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class ActivityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Logs de Acesso');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ModelsActivity $activity)
    {
        return $user->hasPermissionTo('Ver Logs de Acesso');
    }

}
