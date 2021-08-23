<?php

namespace App\Http\Services;

use App\Models\Link;
use App\Models\Page;

class LinkService
{

    /**
     * LinkService constructor.
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
    public function create(array $data, Page $page)
    {
        // dd($data);
        $page->links()->create($data);
    }

    public function batchCreateLinks(
        Page $page,
        array $links,
    ) {
        $page->links()->createMany($links);
    }
}
