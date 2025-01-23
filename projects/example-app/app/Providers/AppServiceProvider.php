<?php

namespace App\Providers;

use App\Http\Repositories\FornecedorRepository;
use App\Http\Repositories\FornecedorRepositoryInterface;
use App\Http\Services\FornecedorService;
use App\Http\Services\FornecedorServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FornecedorServiceInterface::class, FornecedorService::class);
        $this->app->bind(FornecedorRepositoryInterface::class, FornecedorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
