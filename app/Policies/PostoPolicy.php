<?php

namespace App\Policies;

use App\Models\PostoVacinacao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostoVacinacao  $postoVacinacao
     * @return mixed
     */
    public function view(User $user, PostoVacinacao $postoVacinacao)
    {
        dd('teste');
        return $user->tipo == User::TIPO_ENUM['secretaria'] ||
               $user->tipo == User::TIPO_ENUM['colaborador'] ||
               $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostoVacinacao  $postoVacinacao
     * @return mixed
     */
    public function update(User $user, PostoVacinacao $postoVacinacao)
    {
        return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostoVacinacao  $postoVacinacao
     * @return mixed
     */
    public function delete(User $user, PostoVacinacao $postoVacinacao)
    {
        return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostoVacinacao  $postoVacinacao
     * @return mixed
     */
    public function restore(User $user, PostoVacinacao $postoVacinacao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostoVacinacao  $postoVacinacao
     * @return mixed
     */
    public function forceDelete(User $user, PostoVacinacao $postoVacinacao)
    {
        //
    }
}
