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
        $page->links()->create($data);
    }

    /**
     * Update a link
     *
     * @param array $data
     * @return array
     */
    public function update(array $data, Link $link)
    {
        $link->fill($data);
        $link->save();
    }

    /**
     * Delete a link
     *
     * @param array $data
     * @return array
     */
    public function delete(Link $link)
    {
        $link->delete();
    }
}
