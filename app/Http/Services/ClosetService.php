<?php

namespace App\Http\Services;

use App\Models\Closet;
use Illuminate\Support\Facades\Auth;
use Exception;

class ClosetService
{

    protected ItemService $itemService;

    /**
     * PageService constructor.
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Create a page
     *
     * @param array $data
     * @return Closet
     */
    public function create(array $data): Closet
    {
        $closet = new Closet();
        $closet->fill($data);

        if (!$closet->save()) {
            throw new Exception('Closet could not be saved.');
        }

        return $closet;
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
     * Delete a tile
     *
     * @param string $pageId
     * @return array
     */
    public function delete(string $closetId)
    {
        $closet = Closet::find($closetId);
        $closet->tiles()->delete();
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
