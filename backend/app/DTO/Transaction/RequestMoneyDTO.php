<?php

declare(strict_types=1);

namespace App\DTO\Transaction;

class RequestMoneyDTO extends DTO
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
    ) {
    }
}
