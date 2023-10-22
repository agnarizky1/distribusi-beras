<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BerasController;

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
// Route::get('/stockberas', [AdminController::class, 'stock'])->name('stock');

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
    //beras
    Route::get('/admin/stockberas', [BerasController::class, 'index'])->name('admin.stockberas');
    Route::post('/admin/stockberas/create', [BerasController::class, 'store'])->name('admin.stockberas.create');
    Route::get('/admin/stockberas/add', [BerasController::class, 'create'])->name('admin.stockberas.add');
    Route::get('/admin/stockberas/edit/{id}', [BerasController::class, 'edit'])->name('admin.stockberas.edit');
    Route::put('/admin/stockberas/update/{id}', [BerasController::class, 'update'])->name('admin.stockberas.update');
    Route::get('/admin/stockberas/destroy/{id}', [BerasController::class, 'destroy'])->name('admin.stockberas.destroy');
});
