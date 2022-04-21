<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::view('order', 'order.order')->middleware(['auth'])->name('order');
Route::view('orders', 'order.orders')->middleware(['auth'])->name('orders');
Route::view('menu', 'order.menu')->middleware(['auth'])->name('menu');
Route::view('users', 'auth.users')->middleware(['auth'])->name('users');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';
