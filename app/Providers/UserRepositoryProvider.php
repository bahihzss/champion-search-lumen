<?php

namespace App\Providers;

use App\Domain\User\UserRepository;
use App\Infrastructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function () {
            return new UserEloquentRepository();
        });
    }
}
