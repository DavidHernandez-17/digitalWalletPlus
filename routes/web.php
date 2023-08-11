<?php

use App\Http\Controllers\SoapClientController;
use App\Http\Controllers\SoapController;
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
});

# Server SOAP
Route::get('/soap/wsdl', [SoapController::class, 'getWsdl']);
Route::post('/soap', [SoapController::class, 'server']);


# Client SOAP
Route::get('/soap-client/{id}', [SoapClientController::class, 'getClient'])->name('get_user');