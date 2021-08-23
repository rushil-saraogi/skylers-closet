<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePageRequest;
use App\Http\Services\PageService;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
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
     */
    public function list()
    {
        return Inertia::render('Dashboard', [
            'pages' => Auth::user()->pages
        ]);
    }

    /**
     * Get the current user's pages
     *
     */
    public function pageEditor($id)
    {
        return Inertia::render('PageEditor', [
            'page' => Page::find($id)
                ->with('links')
                ->get()
                ->toArray()[0]
        ]);
    }

    /**
     * Create a single page for the current user
     *
     * @param CreatePageRequest $request
     */
    public function create(CreatePageRequest $request)
    {
        $page = $this->pageService->create(array_merge($request->all(), [
            'user_id' => Auth::user()->id
        ]));

        return Inertia::render('PageEditor', [
            'page' => Page::find($page->id)
                ->with('links')
                ->get()
                ->toArray()[0]
        ]);
    }
}
