<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UsersController;
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
})->name('home');

Route::get('/auth', [LoginController::class, 'form'])->name('login');
Route::post('/auth', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'form'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users-show');
Route::post('/users/{id}', [UsersController::class, 'addFriend'])->name('users-add-friend');


// k6 run --vus 10 --duration 10s --summary-export=src/storage/app/public/performance/search-2.json src/resources/js/performance/search.js
Route::get('/units/2', function () {
    return view('units.2');
})->name('unit-2');
