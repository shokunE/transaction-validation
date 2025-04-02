<?php

namespace App\Services;

use App\DTO\Transaction\RequestMoneyDTO;
use App\DTO\Transaction\TransactionDTO;
use App\Models\Transaction;

class TransactionMatcher
{
    public function __construct(protected RequestMoneyValidator $validator)
    {
    }

    public function setDeviation(float $deviationPercent): void
    {
        $this->validator->setDeviation($deviationPercent);
    }

    public function match(RequestMoneyDTO $dto): ?Transaction
    {
        $min = number_format($dto->amount * (1 - $this->validator->getDeviation() / 100), 2, '.', '');
        $max = number_format($dto->amount * (1 + $this->validator->getDeviation() / 100), 2, '.', '');

        $transaction = Transaction::query()
            ->where('currency', $dto->currency)
            ->whereBetween('amount', [$min, $max])
            ->latest('id')
            ->first();

        if (!$transaction) {
            return null;
        }

        $transactionDTO = new TransactionDTO(
            amount: $transaction->amount,
            currency: $transaction->currency
        );

        return $this->validator->validate($dto, $transactionDTO) ? $transaction : null;
    }
}
