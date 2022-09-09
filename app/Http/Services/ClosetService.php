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
     * Get all pages for user
     *
     * @param array $data
     * @return array
     */
    public function list()
    {
        
    }
}
