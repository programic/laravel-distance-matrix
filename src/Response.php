<?php

namespace Programic\DistanceMatrix;

use Carbon\Carbon;

class Response
{
    private $data = [];
    private $success = false;
    private $response = null;

    public function __construct($response)
    {
        $this->response = $response;

        if ($response->status == "OK") {
            $this->success = true;
            $row = $response->rows[0]->elements[0];

            if ($row && isset($row->duration_in_traffic) && isset($row->duration_in_traffic->value)) {
                $durationInSeconds = $row->duration_in_traffic->value;
                $start = Carbon::now()->addSeconds($durationInSeconds);

                // Round time in 5 minutes
                $startRounded = $start->setTime(
                    $start->format('H'),
                    round($start->format('i') / 5) * 5,
                    0
                );

                $start = $startRounded;
                $end = $start->copy()->addMinutes(30);

                $this->data['start'] = $start;
                $this->data['end'] = $end;
                $this->data['distance'] = $row->distance->value ?? null;
                $this->data['duration'] = $row->duration->value ?? null;
                $this->data['duration_in_traffic'] = $row->duration_in_traffic->value ?? null;
            }
        }
    }

    public function __get($param)
    {
        return $this->data[$param];
    }

    public function __set($param, $value)
    {
        $this->data[$param] = $value;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function error()
    {
        return $this->response->error_message;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
