<?php

namespace App\Http\Controllers;
require_once base_path('lib/nusoap/nusoap.php');

use App\Models\User;

class SoapController extends Controller
{
    public function server()
    {
        set_time_limit(300);
        
        $url = request()->root();
        $namespace = "{$url}/soap";

        $server = new \nusoap_server();
        $server->configureWSDL('LaravelSOAP', $namespace);

        // Registramos un método que devuelve un usuario según su ID
        $server->register('getUser',
            ['id' => 'xsd:int'],  // Parámetros de entrada
            ['return' => 'xsd:array'],  // Parámetros de salida
            $namespace,
            false,
            'rpc',
            'encoded',
            'Obtiene un usuario por ID'
        );

        $server->service(file_get_contents("php://input"));
    }

    public function getWsdl()
    {
        $url = request()->root();
        $namespace = "{$url}/soap";

        $server = new \nusoap_server();
        $server->configureWSDL('LaravelSOAP', $namespace);

        // Aquí registras tus métodos, como ya lo estás haciendo
        $server->register('getUser',
            ['id' => 'xsd:int'],  // Parámetros de entrada
            ['return' => 'xsd:array'],  // Parámetros de salida
            $namespace,
            false,
            'rpc',
            'encoded',
            'Obtiene un usuario por ID'
        );

        // Devuelve el WSDL al cliente
        return response($server->wsdl->serialize(), 200, ['Content-Type' => 'text/xml']);
    }

    public function getUser($id)
    {
        if ($id) {
            return User::find($id)->toArray();
        }
        else{
            return ['error' => 'Id no enviado'];
        }
    }
}
