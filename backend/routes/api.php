<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('transaction/request-money', [TransactionController::class, 'requestMoney']);
