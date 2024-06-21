<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('race');
});

Route::post('/create', [RaceController::class, 'create']);
Route::post('/move', [RaceController::class, 'move']);
Route::post('/transport', [RaceController::class, 'transport']);
Route::post('/endGame', [RaceController::class, 'endGame']);
Route::post('/join', [RaceController::class, 'join']);
Route::post('/start', [RaceController::class, 'start']);
Route::post('/end/{race}', [RaceController::class, 'end']);