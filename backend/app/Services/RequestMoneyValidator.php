<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Transaction\RequestMoneyDTO;
use App\DTO\Transaction\TransactionDTO;
use InvalidArgumentException;

class RequestMoneyValidator
{
    public function __construct(protected ?float $deviationPercent = null)
    {
        if (is_null($this->deviationPercent)) {
            $this->deviationPercent = (float) config('services.request_money_validator.deviation_percent');
        }

        if (is_null($this->deviationPercent)) {
            throw new InvalidArgumentException('Deviation percent must be set');
        }

        if ($this->deviationPercent < 0) {
            throw new InvalidArgumentException('Deviation percent must be a positive number');
        }
    }

    public function getDeviation(): float
    {
        return $this->deviationPercent;
    }

    public function setDeviation(float $deviationPercent): void
    {
        $this->deviationPercent = $deviationPercent;
    }

    public function validate(RequestMoneyDTO $request, TransactionDTO $transaction): bool
    {
        if (strcasecmp($request->currency, $transaction->currency) !== 0) {
            return false;
        }

        $requested = $request->amount;
        $actual = $transaction->amount;

        $deviation = abs($requested - $actual) / $requested * 100;

        return $deviation <= $this->deviationPercent;
    }
}
