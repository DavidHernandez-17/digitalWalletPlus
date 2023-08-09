<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use Illuminate\Http\Request;
use App\Services\ClientService;

class SoapController extends Controller
{
    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    public function registerClient($name, $email)
    {
        // // Aquí puedes llamar a tu servicio para registrar el cliente en la base de datos
        // $clientService = new ClientService();
        // $result = $clientService->registerClient($name, $email);

        // // Supongamos que estamos usando la librería Artisaninweb/SoapWrapper para crear el servicio SOAP
        // $this->soapWrapper->add('ClientService', function ($service) use ($result) {
        //     $service->wsdl(config('app.url') . '/wsdl'); // Ruta a la definición WSDL
        //     $service->trace(true); // Opcional: habilitar traza SOAP

        //     // Definir el método disponible en el servicio SOAP
        //     $service->register(function ($name, $email) use ($result) {
        //         return $result;
        //     });
        // });

        // return $this->soapWrapper->serve();
    }
}
