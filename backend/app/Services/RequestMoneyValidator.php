<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Transaction\RequestMoneyDTO;
use App\DTO\Transaction\TransactionDTO;

class RequestMoneyValidator
{
    private const SCALE = 8;

    public function __construct(protected ?float $deviationPercent = null)
    {
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

        $requested = MoneyConverter::toString($request->amount);
        $actual = MoneyConverter::toString($transaction->amount);

        $diff = bcsub($requested, $actual, self::SCALE);

        $absDiff = bccomp($diff, '0', self::SCALE) < 0
            ? bcmul($diff, '-1', self::SCALE)
            : $diff;

        // Calculate the percentage deviation
        $deviationPercent = bcdiv(bcmul($absDiff, '100', self::SCALE), $requested, self::SCALE);

        return bccomp($deviationPercent, (string) $this->deviationPercent, self::SCALE) <= 0;
    }
}
