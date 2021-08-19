<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePageRequest;
use App\Http\Services\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * PageController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
        PageService $pageService
    ) {
        $this->pageService = $pageService;
    }

    /**
     * Get the current user's pages
     *
     * @param Request $request
     */
    public function list(Request $request)
    {
        dd($request);
    }

    /**
     * Create a single page
     *
     * @param CreatePageRequest $request
     */
    public function create(CreatePageRequest $request)
    {
        dd($request);
        
    }
}
