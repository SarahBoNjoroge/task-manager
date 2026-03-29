<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Daily report must come BEFORE the other routes
Route::get('/tasks/report', [TaskController::class, 'report']);

// Main task routes
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);