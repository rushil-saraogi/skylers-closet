<?php

namespace App\Http\Services;

use App\Models\Page;
use Exception;

class PageService
{

    /**
     * PageService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a link
     *
     * @param array $data
     * @return array
     */
    public function create(array $data):Page
    {
        $page = new Page();
        $page->fill($data);
        $page->save();

        if (!$page->save()) {
            throw new Exception('Page could not be saved.');
        }

        return $page;
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
