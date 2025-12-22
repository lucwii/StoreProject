<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('kupacs', App\Http\Controllers\KupacController::class);

Route::resource('dobavljacs', App\Http\Controllers\DobavljacController::class);

Route::resource('artikals', App\Http\Controllers\ArtikalController::class);

Route::resource('prodajas', App\Http\Controllers\ProdajaController::class);

Route::resource('narudzbinas', App\Http\Controllers\NarudzbinaController::class);
