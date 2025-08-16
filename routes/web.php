<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ///return view('welcome');
    //return view('frontend.layouts.index');
    return view('frontend.layouts.index');
});

Route::get('/dashboard', function () {
   // return view('dashboard');
   return view('backend.admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/password-change', [ProfileController::class, 'passwordChange'])->name('password.change');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update.password');
});

require __DIR__.'/auth.php';
