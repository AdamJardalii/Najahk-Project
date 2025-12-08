<?php

use App\Http\Controllers\{
   PairSumController,
   QuoteController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/pair-sum', [PairSumController::class, 'solve']);
Route::get('/quotes', [QuoteController::class, 'index']);
