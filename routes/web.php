<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BerasController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UkuranController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\pembayaranController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DeliveryOrderController;


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

// Route::get('/cetak', function () {
//     return view('admin.distribusi.distribusi_pdf');
// });

// Route::get('/l', function () {
//         return view('auth.x');
//     });
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
    Route::get('/admin/stockberas/show{id}', [BerasController::class, 'show'])->name('admin.stockberas.show');
    Route::get('/admin/stockberas/edit/{id}', [BerasController::class, 'edit'])->name('admin.stockberas.edit');
    Route::put('/admin/stockberas/update/{id_beras}', [BerasController::class, 'update'])->name('admin.stockberas.update');
    Route::get('/admin/stockberas/destroy/{id_beras}', [BerasController::class, 'destroy'])->name('admin.stockberas.destroy');

    Route::get('/admin/jumlahstock/edit/{id}', [BerasController::class, 'editjumlah'])->name('admin.jumlahstock.edit');
    Route::put('/admin/jumlahstock/update', [BerasController::class, 'updatejumlah'])->name('admin.jumlahstock.update');

    //toko
    Route::get('/admin/toko', [TokoController::class, 'index'])->name('admin.toko');
    Route::post('/admin/toko/create', [TokoController::class, 'store'])->name('admin.toko.create');
    Route::get('/admin/toko/add', [TokoController::class, 'create'])->name('admin.toko.add');
    Route::get('/admin/toko/show/{id}', [TokoController::class, 'show'])->name('admin.toko.show');
    Route::get('/admin/toko/edit/{id_toko}', [TokoController::class, 'edit'])->name('admin.toko.edit');
    Route::put('/admin/toko/update/{id_toko}', [TokoController::class, 'update'])->name('admin.toko.update');
    Route::get('/admin/toko/destroy/{id_toko}', [TokoController::class, 'destroy'])->name('admin.toko.destroy');

    //user
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user');
    Route::post('/admin/user/create', [UserController::class, 'store'])->name('admin.user.create');
    Route::get('/admin/user/add', [UserController::class, 'create'])->name('admin.user.add');
    Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    //distribution
    Route::get('/admin/distribution', [DistributionController::class, 'index'])->name('distribution');
    Route::post('/admin/distribution/store', [DistributionController::class, 'store'])->name('distribution.store');
    Route::get('/admin/distribution/create', [DistributionController::class, 'create'])->name('distribution.add');
    Route::get('/admin/distribution/show/{id}', [DistributionController::class, 'show'])->name('distribution.show');
    Route::get('/admin/distribution/destroy/{id}', [DistributionController::class, 'destroy'])->name('distribution.destroy');
    Route::post('/admin/distribution/update', [DistributionController::class, 'update'])->name('distribution.update');
    Route::get('/admin/distribution/cetak/{id}', [DistributionController::class, 'cetak'])->name('distribution.cetak');

    // DeliveryOrder
    Route::get('/admin/DeliveryOrder', [DeliveryOrderController::class, 'index'])->name('admin.DeliveryOrder.index');
    Route::post('/admin/DeliveryOrder/store', [DeliveryOrderController::class, 'store'])->name('admin.DeliveryOrder.store');
    Route::get('/admin/DeliveryOrder/show/{id}', [DeliveryOrderController::class, 'show'])->name('admin.DeliveryOrder.show');
    Route::get('/admin/DeliveryOrder/showDO/{id}', [DeliveryOrderController::class, 'showDO'])->name('admin.DeliveryOrder.showDO');
    Route::get('/admin/DeliveryOrder/destroy/{id}', [DeliveryOrderController::class, 'destroy'])->name('admin.DeliveryOrder.destroy');
    Route::get('/admin/DeliveryOrder/cetak/{id}', [DeliveryOrderController::class, 'cetak'])->name('admin.DeliveryOrder.cetak'); //iki nggo cetak DO/surat jalan sopir

    // penjualan (yang digunakan yaitu tabel distribusi namun nanti yang ditampilkan ada beberapa filter )
    Route::get('/admin/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
    Route::get('/admin/penjualan/show/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/admin/penjualan/destroy/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    //sales
    Route::get('/admin/sales', [SalesController::class, 'index'])->name('admin.sales');
    Route::post('/admin/sales/create', [SalesController::class, 'store'])->name('admin.sales.create');
    Route::get('/admin/sales/add', [SalesController::class, 'create'])->name('admin.sales.add');
    Route::get('/admin/sales/edit/{id}', [SalesController::class, 'edit'])->name('admin.sales.edit');
    Route::put('/admin/sales/update/{id}', [SalesController::class, 'update'])->name('admin.sales.update');
    Route::get('/admin/sales/destroy/{id}', [SalesController::class, 'destroy'])->name('admin.sales.destroy');

    //ukuran
    Route::get('/admin/ukuran', [UkuranController::class, 'index'])->name('admin.ukuran');
    Route::post('/admin/ukuran/create', [UkuranController::class, 'store'])->name('admin.ukuran.create');
    Route::get('/admin/ukuran/add', [UkuranController::class, 'create'])->name('admin.ukuran.add');
    Route::get('/admin/ukuran/edit/{id}', [UkuranController::class, 'edit'])->name('admin.ukuran.edit');
    Route::put('/admin/ukuran/update/{id}', [UkuranController::class, 'update'])->name('admin.ukuran.update');
    Route::get('/admin/ukuran/destroy/{id}', [UkuranController::class, 'destroy'])->name('admin.ukuran.destroy');

    //merk
    Route::get('/admin/merk', [MerkController::class, 'index'])->name('admin.merk');
    Route::post('/admin/merk/create', [MerkController::class, 'store'])->name('admin.merk.create');
    Route::get('/admin/merk/add', [MerkController::class, 'create'])->name('admin.merk.add');
    Route::get('/admin/merk/edit/{id}', [MerkController::class, 'edit'])->name('admin.merk.edit');
    Route::put('/admin/merk/update/{id}', [MerkController::class, 'update'])->name('admin.merk.update');
    Route::get('/admin/merk/destroy/{id}', [MerkController::class, 'destroy'])->name('admin.merk.destroy');

    //Pembayaran (tagihan)
    Route::get('/admin/tagihan', [pembayaranController::class, 'index'])->name('admin.tagihan');
    Route::post('/admin/tagihan/store', [pembayaranController::class, 'store'])->name('tagihan.store');
    Route::get('/admin/tagihan/destroy/{id}', [pembayaranController::class, 'destroy'])->name('admin.tagihan.destroy');
    Route::get('/admin/tagihan/show/{id}', [pembayaranController::class, 'show'])->name('admin.tagihan.show');
    Route::get('/admin/tagihan/cetaknota/{id}', [PembayaranController::class, 'cetak'])->name('pembayaran.cetak');

});
