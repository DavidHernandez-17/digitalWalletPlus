<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\PaymentVerification;
use App\Models\DigitalWallet;
use App\Models\PaymentConcept;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayController extends Controller
{
    public function index(){
        try {
            $concepts = PaymentConcept::all();
            return response()->json($concepts, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }

    public function requestPayment(Request $request){
        # Validar los campos/datos del cliente y billetera
        $validator = Validator::make($request->all(), [
            'document' => 'required',
            'concept' => 'required',
            'pay_to' => 'required|min:5',
            'value' => 'required|integer|min:1',
            'wallet' => 'required',
        ],
        [
            'document.required' =>'El documento es requerido.',
            'concept.required' =>'El concepto es requerido.',
            'pay_to.required' =>'El campo pagar a es requerido.',
            'pay_to.min' =>'El campo pagar a debe ser mínimo de 10 digitos.',
            'value.required' =>'El valor es requerido.',
            'value.min' =>'El valor debe ser positivo, mínimo de 4 digitos',
            'value.integer' =>'El valor no puede ser decimal',
            'wallet.required' =>'La billetera es requerida.',
        ]);

        if ($validator->fails()) {
            // Obtener los mensajes de error del validador
            $errors = $validator->errors();
            
            return response()->json([
                'document' => $errors->first('document'),
                'concept' => $errors->first('concept'),
                'pay_to' => $errors->first('pay_to'),
                'value' => $errors->first('value'),
                'wallet' => $errors->first('wallet'),
            ], 422);
        }

        # Recarga de billetera
        try {

            $user = User::where('document', $request->document)->first();
            
            if ($user) {
                $wallet = DigitalWallet::where('id', $request->wallet)->first();

                # Valida si la billetera del usuario tiene saldo
                if ( $wallet->saldo >= $request->value) {
                    $requestCode = new PaymentVerification();
                    $response = $requestCode->requestGenerateCode($request->document);
                    return response()->json($response , 200);
                }

                return response()->json('No tienes saldo disponible en tu billera '. $wallet->name  , 400);
            }

            return response()->json('Usuario no encontrado.', 404);

        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }

    public function verificationPayment(){
        
    }
}
