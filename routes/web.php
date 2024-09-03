<?php

use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProcessController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('/processes', ProcessController::class)->except([
//     'index', 'create'
// ]);

Route::post('/processes', [ProcessController::class, 'store']);
Route::get('/processes/{process:llave_proceso}', [ProcessController::class, 'show']);
Route::delete('/processes/{process:llave_proceso}', [ProcessController::class, 'destroy']);

require __DIR__.'/auth.php';
