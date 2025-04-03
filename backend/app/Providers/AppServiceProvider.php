<?php

namespace App\Providers;

use App\Services\RequestMoneyValidator;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app
            ->when(RequestMoneyValidator::class)
            ->needs('$deviationPercent')
            ->give(function () {
                $percent = config('services.request_money_validator.deviation_percent');

                if (is_null($percent)) {
                    throw new InvalidArgumentException('Deviation percent must be set');
                }

                if ($percent < 0) {
                    throw new InvalidArgumentException('Deviation percent must be a positive number');
                }

                return (float)$percent;
            });
    }

    public function boot(): void
    {
    }
}
