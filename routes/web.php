<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes(['verify' => true]);

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\VerifyController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// REVIEWS
Route::resource('review', App\Http\Controllers\ReviewController::class);
Route::get('review/displayImages/{name}', [App\Http\Controllers\ReviewController::class, 'displayImages']);

// ADMIN
Route::get('admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
Route::get('admin/reviews', [App\Http\Controllers\AdminController::class, 'reviews'])->name('admin.reviews');
Route::resource('admin', App\Http\Controllers\AdminController::class)->except('index');

// USER
Route::get('home/config', [App\Http\Controllers\HomeController::class, 'config'])->name('home.config');
Route::get('home/config', [App\Http\Controllers\HomeController::class, 'config'])->name('home.config');
Route::get('home/{user}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
Route::put('home/picture/{user}', [App\Http\Controllers\HomeController::class, 'picture'])->name('home.picture');
Route::resource('home', App\Http\Controllers\HomeController::class)->except('show');

// 404 ERROR
Route::fallback(function() {
    return view('errors.404');
});