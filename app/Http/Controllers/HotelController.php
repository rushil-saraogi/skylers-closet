<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHotelRequest;
use App\Http\Services\HotelService;
use App\Http\Services\ImageService;
use App\Http\Services\AppDesignService;
use App\Models\Hotel;
use App\Models\Message;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HotelController extends Controller
{
    protected $hotelService;
    protected $appDesignService;
    protected $imageService;

    /**
     * ClosetController constructor.
     *
     * @param PageService $pageService
     * @param AppDesignService $appDesignService
     * @param ImageService $imageService
     */
    public function __construct(
        HotelService $hotelService,
        AppDesignService $appDesignService,
        ImageService $imageService
    ) {
        $this->hotelService = $hotelService;
        $this->appDesignService = $appDesignService;
        $this->imageService = $imageService;
    }

    /**
     * Render closet
     *
     * @param Request $request
     */
    public function show(Request $request, Closet $closet)
    {
        $closet = $closet->load('items', 'user');
        $owner = $closet->user;

        $props = [
            'closet' => $closet,
            'messages' => Message::where('closet_id', $closet->id)
                ->whereNull('parent_message_id')
                ->with('replies.user', 'user', 'item')
                ->orderBy('created_at', 'desc')
                ->get(),
            'isFollowing' => $closet->followers->contains($owner),
        ];

        if (Auth::check()) {
            $props['user_closets'] = Auth::user()->closets->load('items', 'category');
        }

        return Inertia::render('Closet', $props);
    }

    /**
     * Get current user's closets
     *
     * @param Request $request
     */
    public function currentUser(Request $request)
    {
        return Auth::user()->closets->load('items', 'category');
    }

    /**
     * Create a single page for the current user
     *
     * @param CreateHotelRequest $request
     */
    public function create(CreateHotelRequest $request)
    {
        $hotel = $this->hotelService->create(
            array_merge(
                $request->all(),
                [ 'user_id' => Auth::user()->id ]
            )
        );

        $draftAppDesign = $this->appDesignService->create([
            'user_id' => Auth::user()->id,
            'hotel_id' => $hotel->id,
            'theme' => 'default',
            'layout' => 0,
        ]);

        $hotel->draft_app_design_id = $draftAppDesign->id;
        $hotel->save();
        $hotel->users()->attach(Auth::user()->id);

        return redirect()->back();
    }

    /**
     * Upload and set the logo for the hotel
     *
     * @param AddLogoRequest $request
     */
    public function addLogo(Hotel $hotel, AddLogoRequest $request)
    {
        $this->imageService->addLogoToHotel($hotel, $request->file('logo'));
        return redirect()->back();
    }

    /**
     * Update a page
     *
     * @param Request $request
     */
    public function update(Request $request, Closet $closet)
    {
        $this->closetService->update($request->all(), $closet);

        return redirect()->back();
    }

    /**
     * Delete a Closet
     *
     * @param Request $request
     * @param Closet $closet
     */
    public function delete(Request $request, Closet $closet)
    {
        $this->closetService->delete($closet);

        return Redirect::route('dashboard');
    }

    /**
     * Follow closet
     *
     * @param Closet $closet
     */
    public function follow(Request $request, Closet $closet)
    {
        $this->closetService->follow($closet);
        return redirect()->back();
    }

    /**
     * Unfollow closet
     *
     * @param Closet $closet
     */
    public function unfollow(Request $request, Closet $closet)
    {
        $this->closetService->unfollow($closet);
        return redirect()->back();
    }
}
