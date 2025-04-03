<?php

namespace Tests\Unit\Services;

use App\DTO\Transaction\RequestMoneyDTO;
use App\DTO\Transaction\TransactionDTO;
use App\Services\RequestMoneyValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RequestMoneyValidatorTest extends TestCase
{
    #[DataProvider('validationProvider')]
    public function testValidation(
        float $requestedAmount,
        string $requestedCurrency,
        float $transactionAmount,
        string $transactionCurrency,
        float $deviation,
        bool $expected
    ) {
        $validator = new RequestMoneyValidator($deviation);

        $request = new RequestMoneyDTO(
            amount: $requestedAmount,
            currency: $requestedCurrency
        );

        $transaction = new TransactionDTO(
            amount: $transactionAmount,
            currency: $transactionCurrency
        );

        $result = $validator->validate($request, $transaction);

        $this->assertSame($expected, $result);
    }

    public static function validationProvider(): array
    {
        return [
            //TRUE: 100 USD ~ 90 USD within 10%
            'within 10% deviation' => [100.00, 'USD', 90.00, 'USD', 10.0, true],

            //FALSE: 100 USD vs 97.54 USD with only 1% deviation
            'outside 1% deviation' => [100.00, 'USD', 97.54, 'USD', 1.0, false],

            //FALSE: 100 USD vs 90 EUR (currency mismatch)
            'currency mismatch' => [100.00, 'USD', 90.00, 'EUR', 10.0, false],

            //TRUE: case-insensitive currency
            'case-insensitive currency match' => [100.00, 'usd', 90.00, 'USD', 11.12, true],

            //TRUE: exact match
            'exact match' => [100.00, 'USD', 100.00, 'USD', 0.0, true],

            //FALSE: below minimum
            'below allowed range' => [89.00, 'USD', 100.00, 'USD', 10.0, false],

            //TRUE: above maximum
            'above allowed range' => [111.00, 'USD', 100.00, 'USD', 10.0, true],

            //TRUE: below allowed range int
            'above allowed range int' => [85, 'USD', 90, 'USD', 10.0, true],
        ];
    }
}
