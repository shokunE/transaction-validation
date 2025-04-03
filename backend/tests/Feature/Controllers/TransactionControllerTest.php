<?php

namespace Tests\Feature\Controllers;

use App\Models\Transaction;
use App\Services\TransactionMatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $matcher = $this->app->make(TransactionMatcher::class);
        $matcher->setDeviation(10.0);

        $this->app->instance(TransactionMatcher::class, $matcher);
    }

    #[DataProvider('moneyValidationCases')]
    public function test_money_request_validation(
        float $transactionAmount,
        string $transactionCurrency,
        float $requestedAmount,
        string $requestedCurrency,
        int $expectedStatus,
        string $expectedResponseStatus
    ): void {
        Transaction::factory()->create([
            'currency' => $transactionCurrency,
            'amount' => $transactionAmount,
        ]);

        $response = $this->postJson('/api/transaction/request-money', [
            'amount' => $requestedAmount,
            'currency' => $requestedCurrency,
        ]);

        $response->assertStatus($expectedStatus);
        $response->assertJsonFragment(['status' => $expectedResponseStatus]);
    }

    public static function moneyValidationCases(): array
    {
        return [
            'valid within deviation' => [
                90.00, 'USD',
                95.00, 'usd',
                200, 'Success',
            ],
            'too high deviation' => [
                90.00, 'USD',
                120.00, 'USD',
                400, 'Error',
            ],
            'currency mismatch' => [
                90.00, 'EUR',
                90.00, 'USD',
                400, 'Error',
            ],
        ];
    }
}
