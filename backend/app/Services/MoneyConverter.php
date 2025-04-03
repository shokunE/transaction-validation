<?php

namespace App\Services;

class MoneyConverter
{
    public static function toString(float $amount): string
    {
        return number_format($amount, config('app.money_precision'));
    }
}
