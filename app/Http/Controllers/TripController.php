<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Http\Services\TripService;
use App\Models\Trip;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TripController extends Controller
{
    protected $tripService;

    /**
     * TripController constructor.
     *
     * @param TripService $rripService
     */
    public function __construct(
        TripService $tripService,
    ) {
        $this->tripService = $tripService;
    }

    /**
     * Create a single page for the current user
     *
     * @param CreateHotelRequest $request
     */
    public function create(CreateTripRequest $request)
    {
        $hotel = $this->tripService->create(
            array_merge(
                $request->all(),
                [ 'user_id' => Auth::user()->id ]
            )
        );

        return redirect()->back();
    }
}
