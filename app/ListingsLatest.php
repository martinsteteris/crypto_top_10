<?php
namespace App;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ListingsLatest implements Listings
{

    public function home(){
        var_dump('roof');
    }
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
            "X-CMC_PRO_API_KEY: 35c2b5f0-72d1-419a-94b4-1b67337f484c"
//            "X-CMC_PRO_API_KEY: " . $_ENV['API_KEY']

        ];
        $qs = http_build_query($parameters);
        $request = "{$url}?{$qs}";


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ));

        $response = curl_exec($curl);
        $data =  (json_decode($response));
        curl_close($curl); // Close request
        $loader = new FilesystemLoader('Views');
        $twig = new Environment($loader);
        return $twig->render('index.twig', ['coins' => $data->data]);
    }
}

