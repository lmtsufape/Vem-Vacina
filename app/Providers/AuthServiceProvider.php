<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // 'App\Models\PostoVacinacao' => 'App\Policies\PostoPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //candidato
        Gate::define('ver-candidato', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['secretaria'] ||
               $user->tipo == User::TIPO_ENUM['colaborador'] ||
               $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('baixar-candidato', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('apagar-candidato', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('criar-candidato', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('whatsapp-candidato', function (User $user) {
            return  $user->tipo == User::TIPO_ENUM['colaborador'] ||
                    $user->tipo == User::TIPO_ENUM['gerente'] ||
                    $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('confirmar-vaga-candidato', function (User $user) {
            return  $user->tipo == User::TIPO_ENUM['colaborador'] ||
                    $user->tipo == User::TIPO_ENUM['gerente'] ||
                    $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('vacinado-candidato', function (User $user) {
            return  $user->tipo == User::TIPO_ENUM['colaborador'] ||
                    $user->tipo == User::TIPO_ENUM['gerente'] ||
                    $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('ver-candidato-lote', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['admin'];
        });

        //Posto
        Gate::define('ver-posto', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['secretaria'] ||
               $user->tipo == User::TIPO_ENUM['colaborador'] ||
               $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('editar-posto', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('apagar-posto', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('criar-posto', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        //lote
        Gate::define('ver-lote', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['secretaria'] ||
               $user->tipo == User::TIPO_ENUM['colaborador'] ||
               $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('editar-lote', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('apagar-lote', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('criar-lote', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('distribuir-lote', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        //etapa
        Gate::define('ver-etapa', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['secretaria'] ||
               $user->tipo == User::TIPO_ENUM['colaborador'] ||
               $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('editar-etapa', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('apagar-etapa', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('criar-etapa', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });
        Gate::define('definir-etapa', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        //export
        Gate::define('ver-export', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['secretaria'] ||
               $user->tipo == User::TIPO_ENUM['colaborador'] ||
               $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('baixar-export', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('apagar-export', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });

        Gate::define('criar-export', function (User $user) {
            return $user->tipo == User::TIPO_ENUM['gerente'] ||
               $user->tipo == User::TIPO_ENUM['admin'];
        });
    }
}
