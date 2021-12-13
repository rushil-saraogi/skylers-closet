<?php

namespace App\Http\Controllers;

use App\Http\Services\TileService;
use App\Models\Tile;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TileController extends Controller
{
    /**
     * TileController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
        TileService $tileService
    ) {
        $this->tileService = $tileService;
    }

    /**
     * Create a single Tile for a page
     *
     * @param Request $request
     */
    public function create(Request $request, string $pageId, string $tileType)
    {
        $validated = $this->validateTile($request, $tileType);
        $page = Page::find($pageId);
        $this->tileService->create($validated, $page, $tileType);
        return Redirect::route('page-editor', $pageId);
    }

    /**
     * Update a single Tile for a page
     *
     * @param Request $request
     */
    public function update(Request $request, string $pageId, string $tileId)
    {
        $tile = Tile::find($tileId);
        $validated = $this->validateTile($request, $tile->type);
        $this->tileService->update($validated, $tile);
        return Redirect::route('page-editor', $pageId);
    }

    /**
     * Delete a single Tile for a page
     *
     * @param Request $request
     */
    public function delete(Request $request, string $pageId, string $tileId)
    {
        $tile = Tile::find($tileId);
        $this->tileService->delete($tile);
        return Redirect::route('page-editor', $pageId);
    }

    /**
     * Validate Tile data
     *
     * @param Request $request
     */
    private function validateTile(Request $request, string $type)
    {
        if ($type === Tile::TYPE_LINK) {
            return $request->validate([
                'url' => ['URL'],
                'name' => ['string'],
                'color' => ['string', 'nullable'],
                'icon' => ['string', 'nullable'],
                'title' => ['string', 'nullable'],
                'animated' => ['boolean', 'nullable'],
                'og_title' => ['string', 'nullable'],
                'description' => ['string', 'nullable'],
                'og_description' => ['string', 'nullable'],
                'og_image' => ['URL', 'nullable'],
            ]);
        } elseif ($type === Tile::TYPE_TEXT) {
            return $request->validate([
                'color' => ['string', 'nullable'],
                'header' => ['string', 'required'],
                'body' => ['string', 'nullable'],
            ]);
        } elseif ($type === Tile::TYPE_MAP) {
            return $request->validate([
                'location' => ['string', 'required'],
                'name' => ['string', 'nullable'],
            ]);
        }
        
        return false;
    }
}
