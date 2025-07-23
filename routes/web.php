<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckNotLogged::class])->group(function () {    
    Route::get('/login', [AuthController::class, 'login'])->name('login'); 
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');  
});

  


Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/home', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('newNote');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); 

    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');
});
 
