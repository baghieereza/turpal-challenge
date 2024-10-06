<?php

namespace HeavenlyTours;

use GuzzleHttp\Client;
use HeavenlyTours\Contracts\HeavenlyToursApiInterface;

class HeavenlyToursApi implements HeavenlyToursApiInterface
{
    public function __construct(
        private HeavenlyToursCredentials $heavenlyToursCredentials,
    )
    { }


    public function getTours()
    {
        $response = $this->generateRequest('GET', '/tours');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getTourDetails(string $id)
    {
        $response = $this->generateRequest('GET', '/tours/'.$id);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getPricePerDate($date)
    {
        $response = $this->generateRequest('GET', '/tour-prices?travelDate='.$date);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getAvailability(int $id, $date)
    {
        $response = $this->generateRequest('GET', '/tours/'.$id.'/availability?travelDate='.$date);
        return json_decode($response->getBody()->getContents(), true);
    }

    private function generateRequest($method, $url , $headers = [])
    {
        $client = new Client();
        return $client->request($method, $this->heavenlyToursCredentials->getBaseUrl() . $url, [
            'headers' => array_merge([
                'accept' => 'application/json',
            ], $headers),
        ]);
    }

}
