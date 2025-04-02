<?php

declare(strict_types=1);

namespace App\DTO\Transaction;

class TransactionDTO extends DTO
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
    ) {
    }
}
