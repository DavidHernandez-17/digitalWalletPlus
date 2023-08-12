<?php

use App\Http\Controllers\Customer\RegisterController;
use App\Http\Controllers\Wallet\PayController;
use App\Http\Controllers\Wallet\RechargeWalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Termwind\render;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Customer
Route::post('cliente/registrar', [RegisterController::class, 'customerRegistration'])->name('customer_registration');

# Wallet
Route::post('billetera/recargar/{id}', [RechargeWalletController::class, 'index'])->name('index.recharge_wallet');
Route::post('billetera/recargar', [RechargeWalletController::class, 'recharge'])->name('recharge_wallet');

# Wallet Payment
Route::get('billetera/pagar', [PayController::class, 'index'])->name('index.pay_wallet');
Route::post('billetera/pagar', [PayController::class, 'requestPayment'])->name('requestPayment.pay_wallet');
Route::post('billetera/confirmar/pago', [PayController::class, 'makePayment']);
