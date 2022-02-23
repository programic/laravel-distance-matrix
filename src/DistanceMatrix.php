<?php

namespace Programic\DistanceMatrix;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as GuzzleClient;

class DistanceMatrix
{
    private $endpoint = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    protected $from;
    protected $to;
    protected $departure;
    protected $mode = 'driving';
    protected $language = 'nl-NL';
    protected $units = 'metric';
    protected $traffic_model = 'best_guess';
    protected $departure_time = 'now';

    /**
     * DistanceMatrix constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (! config('services.google.distance.key')) {
            throw new Exception('Google Distance key not set');
        }

        return $this;
    }

    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    public function departure(Carbon $departure)
    {
        $this->departure = $departure;

        return $this;
    }

    public function calculate()
    {
        $response = $this->call($this->endpoint, [
            'origins' => $this->from,
            'destinations' => $this->to,
            'mode' => $this->mode,
            'language' => $this->language,
            'key' => config('services.google.distance.key'),
            'units' => $this->units,
            'traffic_model' => $this->traffic_model,
            'departure_time' => $this->departure_time,
        ]);

        return new Response($response);
    }

    /**
     * Make a call to $url and download its contents with cURL
     * @param string $url
     * @return json_decoded contents of $url
     */
    private function call($url, $params)
    {
        $client = new GuzzleClient();
        $request = $client->getAsync($url, [
            'query' => $params,
            'verify' => false,
            'headers' => [
                'Accept' => 'application/hal+json',
                'Origin' => '*',
            ]
        ]);

        $response = $request->wait();

        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return json_decode($body);
    }
}
