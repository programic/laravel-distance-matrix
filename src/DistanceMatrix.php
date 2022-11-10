<?php

namespace Programic\DistanceMatrix;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Programic\DistanceMatrix\Exceptions\InvalidKeyException;
use Programic\DistanceMatrix\Exceptions\InvalidRequestException;
use Programic\DistanceMatrix\Exceptions\MaxDimensionsExceededException;
use Programic\DistanceMatrix\Exceptions\MaxElementsExceededException;
use Programic\DistanceMatrix\Exceptions\OverDailyLimitException;
use Programic\DistanceMatrix\Exceptions\OverQueryLimitException;
use Programic\DistanceMatrix\Exceptions\RequestDeniedException;
use Programic\DistanceMatrix\Exceptions\UnknownErrorException;

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

    // Distance Matrix statuses
    protected const STATUS_OK = 'OK';
    protected const STATUS_INVALID_REQUEST = 'INVALID_REQUEST';
    protected const STATUS_MAX_ELEMENTS_EXCEEDED = 'MAX_ELEMENTS_EXCEEDED';
    protected const STATUS_MAX_DIMENSIONS_EXCEEDED = 'MAX_DIMENSIONS_EXCEEDED';
    protected const OVER_DAILY_LIMIT = 'OVER_DAILY_LIMIT';
    protected const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    protected const STATUS_REQUEST_DENIED = 'REQUEST_DENIED';

    /**
     * DistanceMatrix constructor.
     *
     * @throws InvalidKeyException
     */
    public function __construct()
    {
        if (! config('services.google.distance.key')) {
            throw new InvalidKeyException();
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
     *
     * @throws InvalidRequestException
     * @throws MaxElementsExceededException
     * @throws MaxDimensionsExceededException
     * @throws OverDailyLimitException
     * @throws OverQueryLimitException
     * @throws RequestDeniedException
     * @throws UnknownErrorException
     */
    private function call($url, $params)
    {
        try {
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

            $body = json_decode($response->getBody()->getContents());
        } catch (\Exception $exception) {
            throw new InvalidRequestException();
        }

        $bodyStatus = strtoupper($body->status) ?? self::STATUS_INVALID_REQUEST;
        if ($bodyStatus === self::STATUS_OK) {
            return $body;
        }

        switch ($bodyStatus) {
            case self::STATUS_INVALID_REQUEST: throw new InvalidRequestException();
            case self::STATUS_MAX_ELEMENTS_EXCEEDED: throw new MaxElementsExceededException();
            case self::STATUS_MAX_DIMENSIONS_EXCEEDED: throw new MaxDimensionsExceededException();
            case self::OVER_DAILY_LIMIT: throw new OverDailyLimitException();
            case self::OVER_QUERY_LIMIT: throw new OverQueryLimitException();
            case self::STATUS_REQUEST_DENIED: throw new RequestDeniedException();
            default: throw new UnknownErrorException();
        };
    }
}
