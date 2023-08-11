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
    public function getClient($id)
    {
        set_time_limit(300);
        $baseUrl = request()->root();

        $wsdl = $baseUrl.'/soap/wsdl';

        // Configuración para el cliente SOAP.
        $options = [
            'trace' => 1,
            'exception' => true,
        ];
  
        // Iniciar el cliente SOAP y realizar la llamada.
        $client = new SoapClient($wsdl);
        return response($client);
        
        try {
            
            $response = $client->getUser(['id' => $id]);

            echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
            echo "RESPONSE:\n" . $client->__getLastResponse() . "\n";
    
            

        } catch (SoapFault $fault) {
            // Manejar errores.
            return response()->json([
                'error' => 'Error al llamar al servidor SOAP',
                'detail' => $fault->getMessage(),
                'request_headers' => $client->__getLastRequestHeaders(),
                'request_body' => $client->__getLastRequest()
            ]);
        }
    }

    // public function getClient($id){

    //     set_time_limit(300);

    //     $baseUrl = request()->root();

    //     $endpoint = "http://127.0.0.1:8000/index.php";
    //     $soapRequest = <<<XML
    //     <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
    //     <s:Body>
    //         <getUser xmlns="{$baseUrl}/soap">
    //             <id>{$id}</id>
    //         </getUser>
    //     </s:Body>
    //     </s:Envelope>
    //     XML;

    //     $client = new Client();

    //     try {
    //         $response = $client->post($endpoint, [
    //             'headers' => [
    //                 'Content-Type' => 'text/xml; charset=UTF-8',
    //                 'SOAPAction' => "{$baseUrl}/soap#getUser"
    //             ],
    //             'body' => $soapRequest,
    //             'timeout' => 300
    //         ]);

    //         // Parsea la respuesta SOAP.
    //         $soapResponse = simplexml_load_string($response->getBody()->getContents());
    //         $data = json_decode(json_encode((array)$soapResponse->Body), true);

    //         return response()->json($data['getUserResponse']);

    //     } catch (RequestException $e) {
    //         // Manejar errores.
    //         return response()->json([
    //             'error' => 'Error al llamar al servidor SOAP',
    //             'detail' => $e->getMessage()
    //         ]);
    //     }
    // }
}
