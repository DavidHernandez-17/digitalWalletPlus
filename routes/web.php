<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Security\PaymentVerification;
use App\Http\Controllers\Wallet\BalanceWalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('billetera/confirmar/pago/{id_sesion}/{id_customer}', [PaymentVerification::class, 'index']);
Route::get('billetera/saldo', [BalanceWalletController::class, 'index'])->name('index.checkbalance');