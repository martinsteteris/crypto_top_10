<?php
namespace App;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ListingsLatest implements Listings
{

    public function getData():string
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 35c2b5f0-72d1-419a-94b4-1b67337f484c'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
// Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $data =  (json_decode($response)); // print json decoded response
        curl_close($curl); // Close request
        $loader = new FilesystemLoader('view');
        $twig = new Environment($loader);
        return $twig->render('index.twig', ['coins' => $data->data]);
    }
}

