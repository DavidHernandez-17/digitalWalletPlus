<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\PaymentVerification;
use App\Models\DigitalWallet;
use App\Models\LogWallet;
use App\Models\PaymentConcept;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
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

        # 
        try {

            $user = User::where('document', $request->document)->first();
            
            if ($user) {

                $wallet = DigitalWallet::where('id', $request->wallet)->first();

                # Valida si la billetera del usuario tiene saldo
                if ( $wallet->saldo >= $request->value) {

                    # Obtengo el id de sessión del cliente
                    $id_session = session()->getId();

                    # Registro bitacora de transacciones
                    LogWallet::create([
                        'id_wallet' => $request->wallet,
                        'id_client' => $user->id,
                        'payment_concept' => $request->concept,
                        'pay_to' => $request->pay_to,
                        'value' => $request->value,
                        'id_session' => $id_session,
                        'status' => '1',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $requestCode = new PaymentVerification();
                    $response = $requestCode->requestGenerateCode($request->document, $id_session);
                    return response()->json($response , 200);
                }

                return response()->json('No tienes saldo disponible en tu billera '. $wallet->name  , 400);
            }

            return response()->json('Usuario no encontrado.', 404);

        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }

    public function makePayment(Request $request){
        # Valida si el código existe
        $existingCode = Validator::make($request->all(), [
            'code' => ['required','exists:verification_codes,code'],

        ]);

        # Comprobar si la validación falla
        if ($existingCode->fails() && $request->code)
        {
            return response(['error', 'El código ingresado no es correcto.'], 404);
        }

        # Obtener el código de verificación
        $verificationCode = VerificationCode::where('code', $request->code)->first();

        # Obtener el usuario relacionado con el código de verificación
        $user = User::where('document', $request->document)->first();

        # Comprobar si el usuario está relacionado con el código ingresado
        if ($user->id != $verificationCode->id_client) {
            return response(['error', 'El código ingresado no está relacionado con el usuario.'], 404);
        }

        # Comprobar si el código de verificación ha expirado
        if (Carbon::now()->isAfter($verificationCode->expire_at)) {
            return response(['error', 'El código ingresado ha expirado.'], 404);
        }

        # Validar si la sesión está habilitada
        $transactionEnabled = LogWallet::where('id_client', $user->id)
            ->where('status', '1')
            ->latest()->first();
        
        if ($transactionEnabled && $transactionEnabled->id_session == $request->id_session) {
            
            # Descontar valor de la billetera
            $wallet = DigitalWallet::where('id', $transactionEnabled->id_wallet)->first();
            $wallet->saldo -= (int)$transactionEnabled->value;
            $wallet->save();

            # Deshabilito id session
            $transactionEnabled->status = 0;
            $transactionEnabled->save();

            # Expirar el código de verificación
            $verificationCode->update([
                'expire_at' => Carbon::now()->addMinutes(-10),
            ]);

            return response(['success', 'El pago se ha realizado correctamente'], 200);
        }
        
        return response(['error', 'Error al realizar el pago, id session inactivo'], 404);
    }
}
