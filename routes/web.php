<?php

use App\Http\Controllers\ComprarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('can:admin.per')->get('/productos', [ProductosController::class, 'index'])->name('product.index');
Route::middleware('auth')->post('/save_product', [ProductosController::class, 'store'])->name('product.save');
Route::middleware('auth')->post('/delete_product', [ProductosController::class, 'destroy'])->name('product.delete');
Route::middleware('auth')->post('/productos_item', [ProductosController::class, 'show'])->name('product.edit');
Route::middleware('auth')->post('/productos_edit', [ProductosController::class, 'update'])->name('product.saveEdit');

Route::middleware('auth')->get('/comprar', [ComprarController::class, 'index'])->name('comprar.index');
Route::middleware('auth')->post('/comprar', [ComprarController::class, 'store'])->name('comprar.save');


Route::middleware('can:admin.per')->get('/facturas', [InvoiceController::class, 'index'])->name('invoice.index');
Route::middleware('can:admin.per')->post('/facturas', [InvoiceController::class, 'store'])->name('invoice.emitir');
Route::middleware('can:admin.per')->post('/facturas-lista', [InvoiceController::class, 'show'])->name('invoice.listar');