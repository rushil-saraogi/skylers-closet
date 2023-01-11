<?php

namespace App\Http\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Exception;

class HotelService
{

    protected AppDesignService $appDesignService;

    /**
     * PageService constructor.
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Create a hotel
     *
     * @param array $data
     * @return Hotel
     */
    public function create(array $data): Hotel
    {
        $hotel = new Hotel();
        $hotel->fill($data);

        if (!$hotel->save()) {
            throw new Exception('Hotel could not be saved.');
        }

        return $hotel;
    }

    /**
     * Update a page
     *
     * @param array $data
     * @return Closet
     */
    public function update(array $data, Closet $closet) : Closet
    {
        $closet->fill($data);
        $closet->save();

        if (!$closet->save()) {
            throw new Exception('Page could not be saved.');
        }

        return $closet;
    }

    /**
     * Delete a closet
     *
     * @param Closet $closer
     * @return array
     */
    public function delete(Closet $closet)
    {
        $closet->delete();
    }

    /**
     * Follow closet
     *
     * @param Closet $closet
     * @return array
     */
    public function follow(Closet $closet)
    {
        if ($closet->followers->contains(Auth::user())) {
            $this->unfollow($closet);
            return;
        }

        $closet->followers()->attach(Auth::user());
    }

    /**
     * Unfollow closet
     *
     * @param User $user
     * @return array
     */
    public function unfollow(Closet $closet)
    {
        $closet->followers()->detach(Auth::user());
    }
}
