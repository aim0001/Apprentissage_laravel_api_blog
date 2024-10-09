<?php

use App\Http\Controllers\Api\Auth\SessionController;
use App\Http\Controllers\Api\UserControlller;
use Illuminate\Support\Facades\Route;

// Inscrire un utilisateur
Route::post('register', [SessionController::class, 'register']);
Route::get('login', [SessionController::class, 'login'])->name("login");
Route::post('login', [SessionController::class, 'doLogin']);
