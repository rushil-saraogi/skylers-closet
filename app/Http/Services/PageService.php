<?php

namespace App\Http\Services;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Exception;

class PageService
{

    /**
     * PageService constructor.
     */
    public function __construct(TileService $tileService)
    {
        $this->tileService = $tileService;
    }

    /**
     * Create a page
     *
     * @param array $data
     * @return array
     */
    public function create(array $data):Page
    {
        $page = new Page();
        $page->fill(array_merge($data, [
            'user_id' => Auth::user()->id,
        ]));

        if (!$page->save()) {
            throw new Exception('Page could not be saved.');
        }

        $this->tileService->createInitialTiles($page);

        return $page;
    }

    /**
     * Update a page
     *
     * @param array $data
     * @return array
     */
    public function update(array $data, string $pageId):Page
    {
        $page = Page::find($pageId);
        $page->fill($data);
        $page->save();

        if (!$page->save()) {
            throw new Exception('Page could not be saved.');
        }

        return $page;
    }

    /**
     * Delete a tile
     *
     * @param string $pageId
     * @return array
     */
    public function delete(string $pageId)
    {
        $page = Page::find($pageId);
        $page->tiles()->delete();
        $page->delete();
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
