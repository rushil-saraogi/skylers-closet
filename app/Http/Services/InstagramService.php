<?php

namespace App\Http\Services;

use App\Models\Closet;
use Illuminate\Support\Facades\Auth;
use Exception;

class InstagramService
{

    /**
     * PageService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a page
     *
     * @param array $data
     * @return array
     */
    public function create(array $data):Closet
    {
        $page = new Closet();
        $page->fill(array_merge($data, [
            'user_id' => Auth::user()->id,
        ]));

        if (!$page->save()) {
            throw new Exception('Page could not be saved.');
        }

        return $page;
    }
}
