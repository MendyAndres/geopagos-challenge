<?php

namespace App\Providers;

use App\Domain\Players\Repositories\PlayerRepositoryInterface;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;
use App\Domain\Tournaments\Services\ExecuteMatchService;
use App\Infrastructure\Players\Repositories\EloquentPlayerRepository;
use App\Infrastructure\Tournaments\Repositories\EloquentTournamentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryInterface::class, EloquentPlayerRepository::class);
        $this->app->bind(TournamentRepositoryInterface::class, EloquentTournamentRepository::class);
        $this->app->singleton(ExecuteMatchService::class, function ($app) {
            return new ExecuteMatchService();
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
