<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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



// Route::get('/admin', function () {
//     return view('superadmin.dashboard');
// });
Route::get('/stokberas', [AdminController::class, 'stok'])->name('stok');

// Login
Route::get('/', [AuthController::class, "login"])->name('login');
Route::post('/dologin', [AuthController::class, "doLogin"])->name('do.login');
// Register
Route::get('/register', [AuthController::class, "register"])->name('register');
Route::post('/register', [AuthController::class, "doRegister"])->name('do.register');
// Logout
Route::get('/logout', [AuthController::class, "logout"])->name('logout');

Route::group(['middleware' => ['auth', 'Role:superadmin,admin']], function () {
    //input admin
    Route::get('/admin', [AdminController::class, 'index'])->name('superadmin.dashboard');
});
