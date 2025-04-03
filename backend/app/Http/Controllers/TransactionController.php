<?php

namespace App\Http\Controllers;

use App\DTO\Transaction\RequestMoneyDTO;
use App\Http\Requests\RequestMoney;
use App\Services\TransactionMatcher;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function requestMoney(RequestMoney $request, TransactionMatcher $matcher): JsonResponse
    {
        $dto = new RequestMoneyDTO(
            amount: (float) $request->input('amount'),
            currency: strtoupper($request->input('currency'))
        );

        $transaction = $matcher->match($dto);

        if (!$transaction) {
            return $this->errorResponse('No matching transaction found');
        }

        return $this->successResponse(['transaction' => $transaction]);
    }
}
