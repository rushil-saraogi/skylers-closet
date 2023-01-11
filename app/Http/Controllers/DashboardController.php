<?php

namespace App\Http\Controllers;

use App\Models\Closet;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    /**
     * ClosetController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
    ) {
    }

    public function home(Request $request)
    {
        return Auth::user()
            ? Inertia::render('Home', [])
            : Inertia::render('Landing', []);
    }

    public function design(Request $request)
    {
        return Inertia::render('Design', []);
    }

    public function hotels(Request $request)
    {
        return Inertia::render('Hotels', [
            'hotels' => Auth::user()->hotels,
        ]);
    }

    public function trips(Request $request)
    {
        return Inertia::render('Trips', [
            'hotels' => Auth::user()->hotels,
        ]);
    }

    public function employees(Request $request)
    {
        $hotels = Auth::user()->hotels;
        $hotelIds = $hotels->pluck('id');

        return Inertia::render('Employees', [
            'hotels' => Auth::user()->hotels,
            'employees' => User::where('role', 'employee')
                ->whereHas('hotels', function($q) use($hotelIds) {
                    $q->whereIn('hotel_id', $hotelIds);
                })
                ->get(),
        ]);
    }

    public function guests(Request $request)
    {
        return Inertia::render('Guests', []);
    }
}
