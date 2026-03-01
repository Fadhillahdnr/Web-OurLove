<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MomentController;

Route::get('/', [MomentController::class, 'index']);
Route::post('/celebrate', [MomentController::class, 'celebrate'])->name('celebrate');
Route::get('/create', [MomentController::class, 'create']);
Route::post('/store', [MomentController::class, 'store']);
Route::view('/love-letter', 'love-letter');
Route::get('/moments/{identifier}', [MomentController::class, 'show'])
    ->name('moments.show');
Route::post('/moments/store', [MomentController::class, 'store'])
    ->name('moments.store');