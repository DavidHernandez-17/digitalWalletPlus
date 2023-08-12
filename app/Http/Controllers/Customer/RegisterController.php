<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function customerRegistration(Request $request){
        # Validación base de datos
        $document_exists = User::where('document', $request->document)->first();
        if ($document_exists) {
            return response()->json([
                'document' => 'Este documento ya existe.'
            ], 422);
        }

        # Validar los campos/datos del usuario
        $validator = Validator::make($request->all(), [
            'document' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'cell_phone' => 'required|min:10',
        ],
        [
            'document.required' =>'El documento es requerido.',
            'full_name.required' =>'El nombre es requerido.',
            'email.required' =>'El email es requerido.',
            'email.email' =>'El email ingresado no es correcto.',
            'cell_phone.required' =>'El celular es requerido.',
            'cell_phone.min' =>'El celular debe tener mínimo 10 digitos.',
        ]);

        if ($validator->fails()) {
            // Obtener lso mensajes de error del validador
            $errors = $validator->errors();
            
            return response()->json([
                'document' => $errors->first('document'),
                'full_name' => $errors->first('full_name'),
                'email' => $errors->first('email'),
                'cell_phone' => $errors->first('cell_phone'),
            ], 422);
        }

        # Creación de usuario
        try {
            User::create([
                'document' => $request->document,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'cell_phone' => $request->cell_phone,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    
            return response()->json('El usuario fue creado correctamente', 200);

        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }
}
