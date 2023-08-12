<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\DigitalWallet;
use App\Models\User;
use Illuminate\Http\Request;

class RechargeWalletController extends Controller
{
    public function index($id){
        try {
            if ($id) {
                $user = User::where('document', $id)->first();
                $wallets = DigitalWallet::where('id_client', $user->id)->get();
    
                return response()->json($wallets, 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }

    public function recharge(Request $request){

    }
}
