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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/reservation', function() {
    return view('reservation');
})->name('reservation');

Route::get('/dashboard', function() {
    return view('dashboard', ['type' => 1]);
})->name('dashboard');

Route::get('/dashboard_all', function() {
    return view('dashboard', ['type' => 2]);
})->name('dashboard_all');