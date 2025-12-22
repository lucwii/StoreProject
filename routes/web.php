<?php

use App\Http\Controllers\ProdajaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('kupacs', App\Http\Controllers\KupacController::class);
    
    Route::resource('dobavljacs', App\Http\Controllers\DobavljacController::class);
    
    Route::resource('artikals', App\Http\Controllers\ArtikalController::class);
    
    Route::resource('prodajas', App\Http\Controllers\ProdajaController::class);
    
    Route::resource('narudzbinas', App\Http\Controllers\NarudzbinaController::class);

    Route::get('/prodaja', [ProdajaController::class, 'create'])->name('prodajas.create')->middleware('auth');
Route::post('/prodaja', [ProdajaController::class, 'store'])->name('prodajas.store')->middleware('auth');

});

require __DIR__.'/auth.php';


