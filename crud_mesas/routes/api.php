<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MesasController;

Route::get('/mesas', [MesasController::class, 'index']);

Route::get('/mesas/{id}', [MesasController::class, 'show']);


Route::post('/mesas', [MesasController::class, 'store']);

Route::put('/mesas/{id}', [MesasController::class, 'update']);

Route::patch('/mesas/{id}', [MesasController::class, 'updatePartial']);

Route::delete('/mesas/{id}', [MesasController::class, 'destroy']);
