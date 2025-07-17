<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login'); 
Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');    
Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); 


Route::get('/logout', [MainController::class, 'index']); 

