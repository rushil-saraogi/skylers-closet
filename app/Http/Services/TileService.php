<?php

namespace App\Http\Services;

use App\Models\Tile;
use App\Models\Page;

class TileService
{

    /**
     * TileService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a tile
     *
     * @param array $data
     * @return array
     */
    public function create(array $data, Page $page, string $type)
    {
        $page->tiles()->create([
            'data' => $data,
            'type' => $type
        ]);
    }

    /**
     * Update a tile
     *
     * @param array $data
     * @return array
     */
    public function update(array $data, Tile $tile)
    {
        $tile->fill(['data' => $data]);
        $tile->save();
    }

    /**
     * Delete a link
     *
     * @param array $data
     * @return array
     */
    public function delete(Tile $tile)
    {
        $tile->delete();
    }
}
