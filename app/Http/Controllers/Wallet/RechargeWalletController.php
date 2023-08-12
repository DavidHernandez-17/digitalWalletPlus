<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\DigitalWallet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

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
        # Validar los campos/datos del cliente y billetera
        $validator = Validator::make($request->all(), [
            'document' => 'required',
            'cell_phone' => 'required|min:10',
            'value' => 'required|min:4',
            'wallet' => 'required',
        ],
        [
            'document.required' =>'El documento es requerido.',
            'cell_phone.required' =>'El celular es requerido.',
            'cell_phone.min' =>'El celular debe tener mínimo 10 digitos.',
            'value.required' =>'El valor es requerido.',
            'value.min' =>'El valor debe ser mínimo de 1000.',
            'wallet.required' =>'El nombre de la billetera es requerido.',
            'wallet.min' =>'El nombre de la billetera debe tener mínimo 4 digitos.',
        ]);

        if ($validator->fails()) {
            // Obtener los mensajes de error del validador
            $errors = $validator->errors();
            
            return response()->json([
                'document' => $errors->first('document'),
                'cell_phone' => $errors->first('cell_phone'),
                'value' => $errors->first('value'),
                'wallet' => $errors->first('wallet'),
            ], 422);
        }

        # Recarga de billetera
        try {

            $user = User::where('document', $request->document)
                ->where('cell_phone', $request->cell_phone)
                ->first();
            
            if ($user) {
                $wallet = DigitalWallet::where('id', $request->wallet)->first();

                # Actualizar datos de la billetera
                $wallet->saldo += (int)$request->value;
                $wallet->save();
        
                return response()->json('La billetera '. $wallet->name . ' fue recargada correctamente.' , 200);
            }

            return response()->json('Los datos documento y celular no coinciden con el cliente', 404);

        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }
}
