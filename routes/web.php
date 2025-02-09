<?php

use App\Http\Controllers\InicioController;
use App\Livewire\ShowUserOrders;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class,'index'])->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/userorders',ShowUserOrders::class)->name('showuserorders');
});
