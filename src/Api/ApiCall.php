<?php 

namespace App\Api;

Class ApiCall
{

    private $url = 'https://api.openweathermap.org/geo/1.0/zip?zip=';

    private $apikey= 'ef67e96d44d75c418e4d22debbd10d22';


    public function __construct()
    {

    }

    public function getApiData($cp)
    { 
        // $response = file_get_contents('https://api.openweathermap.org/geo/1.0/zip?zip=75017,FR&limit=5&appid=ef67e96d44d75c418e4d22debbd10d22');

        $response = file_get_contents($this->url.$cp.',FR&limit=5&appid='.$this->apikey);
        $response = json_decode($response);
        return $response;

    }
}

?>