<?php

namespace App\Http\Controllers;

use App\Http\Services\ItemService;
use App\Models\Item;
use App\Models\Closet;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * TileController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
        ItemService $itemService
    ) {
        $this->itemService = $itemService;
    }

    /**
     * Add an item to a closet
     *
     * @param Request $request
     */
    public function create(Request $request, Closet $closet)
    {
        $validated = $this->validateItem($request);
        $this->itemService->create($validated, $closet);
        return redirect()->back();
    }

    /**
     * Copy an item and add to closet
     *
     * @param Request $request
     */
    public function copy(Request $request, Closet $closet, Item $item)
    {
        $this->itemService->create($item->toArray(), $closet);
        $request->session()->flash('flash.banner', 'Saved to ' . $closet->name . '!');
        $request->session()->flash('flash.bannerStyle', 'success');
        return response(true, 200);
    }

    /**
     * Removes item from closet by URL
     *
     * @param Request $request
     */
    public function removeByUrl(Request $request, Closet $closet, Item $item)
    {
        $this->itemService->deleteByUrl($closet, $item->url);
        return response(true, 200);
    }

    /**
     * Update a single Tile for a page
     *
     * @param Request $request
     */
    public function update(Request $request, Closet $closet, Item $item)
    {
        $validated = $this->validateItem($request);
        $this->itemService->update($validated, $closet, $item);
        return redirect()->back();
    }

    /**
     * Update a single item
     *
     * @param Request $request
     */
    public function updateWithoutIntertia(Request $request, Closet $closet, Item $item)
    {
        $validated = $this->validateItem($request);
        $item = $this->itemService->update($validated, $closet, $item);
        return response()->json($item);
    }

    /**
     * Delete a single Tile for a page
     *
     * @param Request $request
     */
    public function delete(Request $request, Closet $closet, Item $item)
    {
        $this->itemService->delete($closet, $item);
        return redirect()->back();
    }

    /**
     * Validate Tile data
     *
     * @param Request $request
     */
    private function validateItem(Request $request)
    {
        return $request->validate([
            'url' => ['URL'],
            'title' => ['string'],
            'item_order' => ['integer', 'nullable'],
            'price' => ['numeric', 'nullable'],
            'image' => ['string', 'nullable'],
            'brand' => ['string', 'nullable'],
            'model' => ['string', 'nullable'],
            'asin' => ['string', 'nullable'],
            'custom_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);
    }
}
