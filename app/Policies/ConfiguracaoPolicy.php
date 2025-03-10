<?php

namespace App\Policies;

use App\Models\Configuracao;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConfiguracaoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Configuração');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Configuracao $configuracao): bool
    {
        return $user->hasPermissionTo('Ver Configuração');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Configuração');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Configuracao $configuracao): bool
    {
        return $user->hasPermissionTo('Atualizar Configuração');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Configuracao $configuracao): bool
    {
        return $user->hasPermissionTo('Deletar Configuração');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Configuracao $configuracao): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Configuracao $configuracao): bool
    {
        //
    }
}
