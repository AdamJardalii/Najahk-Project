<?php

use App\Http\Controllers\PairSumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

   Route::post('/pair-sum', [PairSumController::class, 'solve']);
