<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            // Asumiendo que tienes una columna 'role' en tu tabla 'users'
            return $user->role === 'admin';
        });

        Gate::define('tutor', function (User $user) {
            // Asumiendo que tienes una columna 'role' en tu tabla 'users'
            // y que el código del tutor se almacena en 'codigo_tutor' en la tabla users
            return $user->role === 'tutor' && !is_null($user->codigo_tutor);
        });
    }
}
