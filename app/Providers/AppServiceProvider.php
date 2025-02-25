<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Operacao;
use App\Observers\OperacaoObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registra o Observer
    Operacao::observe(OperacaoObserver::class);
    }
}
