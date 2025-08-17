<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfileController;

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

Route::controller(SocialController::class)->prefix('social')->group(function(){
    Route::get('/view', 'view')->name('view.social');
    Route::get('/add', 'add')->name('add.social');
    Route::post('/store', 'store')->name('social.store');
    Route::get('/edit/{id}', 'edit')->name('edit.social');
    Route::post('/update/{id}', 'update')->name('social.update');
    Route::get('/delete/{id}', 'delete')->name('delete.social');
});




require __DIR__.'/auth.php';
