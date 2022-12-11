<?php

namespace App\Http\Services;

use Goutte\Client;
use App\Models\Closet;
use App\Models\Item;

class SearchService
{
    protected $client;
    /**
     * SearchService constructor.
     *
     */
    public function __construct() {
        $this->client = new Client();
    }

    /**
     * Search using query string
     *
     * @param Request $request
     */
    public function search(string $query)
    {
        $closets = Closet::whereFuzzy('name', $query)
            // ->orWhereFuzzy('description', $queryString)
            ->with('user')
            ->get();
        
        $items = Item::whereFuzzy('title', $query)
            ->with('closet.user')
            ->get();

        return response()->json([
            'closets' => $closets,
            'items' => $items,
        ]);
    }

}
