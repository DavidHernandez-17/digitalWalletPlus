<?php

namespace App\Http\Controllers;
require_once base_path('lib/nusoap/nusoap.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SoapClient;
use SoapFault;

class SoapClientController extends Controller
{
    // public function getClient($id)
    // {
    //     $baseUrl = request()->root();

    //     // Configuración para el cliente SOAP.
    //     $soapOptions = [
    //         'keep_alive' => false,
    //         'location' => "http://127.0.0.1:8000/index.php",
    //         'uri' => "{$baseUrl}/soap",
    //         'trace' => 1,
    //         'connection_timeout' => 300,
    //         'default_socket_timeout' => 300
    //     ];
    
    //     try {
    //         // Iniciar el cliente SOAP y realizar la llamada.
    //         $client = new SoapClient(null, $soapOptions);
    //         $response = $client->getUser(['id' => $id]);
    
    //         return response()->json($response);
    //     } catch (SoapFault $fault) {
    //         // Manejar errores.
    //         return response()->json([
    //             'error' => 'Error al llamar al servidor SOAP',
    //             'detail' => $fault->getMessage(),
    //             'request_headers' => $client->__getLastRequestHeaders(),
    //             'request_body' => $client->__getLastRequest()
    //         ]);
    //     }
    // }

    public function getClient($id){

        set_time_limit(300);

        $baseUrl = request()->root();

        $endpoint = "http://127.0.0.1:8000/index.php";
        $soapRequest = <<<XML
        <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
        <s:Body>
            <getUser xmlns="{$baseUrl}/soap">
                <id>{$id}</id>
            </getUser>
        </s:Body>
        </s:Envelope>
        XML;

        $client = new Client();

        try {
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'SOAPAction' => "{$baseUrl}/soap#getUser"
                ],
                'body' => $soapRequest,
                'timeout' => 300
            ]);

            // Parsea la respuesta SOAP.
            $soapResponse = simplexml_load_string($response->getBody()->getContents());
            $data = json_decode(json_encode((array)$soapResponse->Body), true);

            return response()->json($data['getUserResponse']);

        } catch (RequestException $e) {
            // Manejar errores.
            return response()->json([
                'error' => 'Error al llamar al servidor SOAP',
                'detail' => $e->getMessage()
            ]);
        }
    }
}
