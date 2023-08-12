<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\SendEmailCodeController;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentVerification extends Controller
{
    public function requestGenerateCode($document)
    {
        # Valida si el documento (cliente) ingreso existe
        $customer = User::where('document', $document)->first();

        # Comprobar si la validación falla
        if (!$customer)
        {
            return response('El documento ingresado no existe en la base de datos.', 404);
        }
        else{
            # Generar OTP
            $generateCode = $this->createOTP($customer->id);
            
            # Envío de código OTP a email
            $sendMail = new SendEmailCodeController();
            $isSent = $sendMail->sendCodeMail($customer->email, 'Código de seguridad - pagos billetera digital', 'mail/MailCode', $generateCode, $document );

            if ( !empty($isSent && $isSent == 'true') ) {
                return 'El código de seguridad fue enviado correctamente';
            }
            else{
                return response('No se pudo enviar el código de seguridad al correo electrónico. Error: '.$isSent, 500);
            }
        }
    }

    public function createOTP($id_client)
    {
        # Busca código OTP relacionado con el usuario
        $verificationCode = VerificationCode::where('id_client', $id_client)->latest()->first();

        # Validar la existencia de un código OTP y verificar si ha expirado
        if($verificationCode && Carbon::now()->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        # Difine el rango para control del ciclo
        $uniqueCode = false;

        while (!$uniqueCode) {
            // Crear nuevo código
            $code = rand(000000,999999);

            if(strlen($code) == 6)
            {
                //Valida si el codigo existe
                $existingCode = Validator::make(['code' => $code], [
                    'code' => 'exists:verification_codes,code',
                ]);
                
                if ($existingCode->fails()) {
                    //Si el código no existe aún, créalo para el usuario.
                    $verificationCode = VerificationCode::create([
                        'id_client' => $id_client,
                        'code' => $code,
                        'expire_at' => Carbon::now()->addMinutes(10)
                    ]);

                    $uniqueCode = true;
                }
            }
        }

        return $verificationCode;

    }
}
