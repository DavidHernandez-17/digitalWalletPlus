<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\DigitalWallet;
use App\Models\LogWallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BalanceWalletController extends Controller
{
    public function index($id_customer) {
        return view('wallet.balance', [
            'id_customer' => $id_customer
        ]);
    }
    
    public function validateResquest(Request $request){
        # Validar los campos/datos del cliente y billetera
        $validator = Validator::make($request->all(), [
            'document' => 'required',
            'cell_phone' => 'required|min:10',
        ],
        [
            'document.required' =>'El documento es requerido.',
            'cell_phone.required' =>'El celular es requerido.',
            'cell_phone.min' =>'El celular debe tener mínimo 10 digitos.',
        ]);

        if ($validator->fails()) {
            // Obtener los mensajes de error del validador
            $errors = $validator->errors();
            
            return response()->json([
                'document' => $errors->first('document'),
                'cell_phone' => $errors->first('cell_phone'),
            ], 422);
        }

        $customer = User::where('document', $request->document)
            ->where('cell_phone', $request->cell_phone)
            ->first();

        if ($customer) {
            $redirection = route('index.checkbalance', ['id_customer' => $request->document]);
            return response()->json([
                'message' => 'Operación existosa',
                'redirect' => $redirection
            ]);
        }

        return response()->json('Los datos ingresados no coinciden', 404);
    }

    public function getBalances(Request $request){
        $customer = User::where('document', $request->document)->first();
        try {
            if ($customer) {
                $balancesCustomer = DigitalWallet::where('id_client', $customer->id)->get();
                return response()->json([
                    'balancesCustomer' => $balancesCustomer,
                    'customer' => $customer
                ], 200);
            }
    
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }

    public function getMovements(Request $request){
        $customer = User::where('document', $request->document)->first();

        try {
            if ($customer) {
                // $movementsCustomer = LogWallet::where('id_client', $customer->id)->get();
                $movementsCustomer = $customer->movements;
                return response()->json([
                    'movementsCustomer' => $movementsCustomer,
                ], 200);
            }
    
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }

}
