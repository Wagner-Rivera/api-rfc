<?php

namespace App\Providers;

use App\Domain\Rfc\Contracts\RfcDocumentRepositoryInterface;
use App\Domain\Rfc\Contracts\RfcDocumentServiceInterface;
use App\Domain\Rfc\Repositories\EloquentRfcDocumentRepository;
use App\Domain\Rfc\Services\RfcDocumentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RfcDocumentRepositoryInterface::class, EloquentRfcDocumentRepository::class);
        $this->app->bind(RfcDocumentServiceInterface::class, RfcDocumentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

