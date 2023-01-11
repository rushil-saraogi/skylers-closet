<?php

namespace App\Http\Services;

use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Exception;

class TripService
{

    /**
     * TripService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a hotel
     *
     * @param array $data
     * @return Hotel
     */
    public function create(array $data): Trip
    {
        dd($data);
        $trip = new Trip();
        $trip->fill($data);

        if (!$trip->save()) {
            throw new Exception('Trip could not be saved.');
        }

        return $trip;
    }
}
