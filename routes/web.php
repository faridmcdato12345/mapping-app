<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProfileController;
use App\Models\People;
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

    Route::get('/data',[PeopleController::class, 'index'])->name('people.index');
    Route::post('/data',[PeopleController::class, 'store'])->name('people.store');

    Route::get('/api',[PeopleController::class,'api'])->name('people.api');
});

require __DIR__.'/auth.php';
