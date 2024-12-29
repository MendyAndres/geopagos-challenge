<?php

use App\Infrastructure\Framework\Controllers\Tournaments\ExecuteTournamentController;
use App\Infrastructure\Framework\Controllers\Tournaments\GetTournamentController;
use App\Infrastructure\Framework\Controllers\Tournaments\ListTournamentsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::get('/tournaments', ListTournamentsController::class);
    Route::get('/tournaments/{id}', GetTournamentController::class);
    Route::post('/tournaments/execute', ExecuteTournamentController::class);

});

