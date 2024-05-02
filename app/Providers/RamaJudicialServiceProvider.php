<?php

namespace App\Providers;

use App\Services\RamaJudicial\RamaJudicialProcessesService;
use Illuminate\Support\ServiceProvider;

class RamaJudicialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RamaJudicialProcessesService::class,
            fn() => new RamaJudicialProcessesService()
        );
    }
}
