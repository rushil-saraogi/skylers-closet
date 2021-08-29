<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePageRequest;
use App\Http\Services\PageService;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $page = Page::with('links')->findOrFail($id)->toArray();

        if (!$page) {
            return Inertia::render('Dashboard', [
                'pages' => Auth::user()->pages
            ]);
        }

        return Inertia::render('PageEditor', [
            'page' => $page
        ]);
    }

    /**
     * Create a single page for the current user
     *
     * @param CreatePageRequest $request
     */
    public function create(CreatePageRequest $request)
    {
        $page = $this->pageService->create($request->all());

        return Redirect::route('page-editor', $page->id);
    }

    /**
     * Update a page
     *
     * @param Request $request
     */
    public function update(Request $request, string $pageId)
    {
        $page = $this->pageService->update($request->all(), $pageId);

        return Redirect::route('page-editor', $page->id);
    }

    /**
     * Delete a page
     *
     * @param Request $request
     */
    public function delete(string $pageId)
    {
        $this->pageService->delete($pageId);

        return Redirect::route('dashboard');
    }

    public function pubsite(string $slug)
    {
        $page = Page::with('links')->where('slug', $slug)->first();
        
        return Inertia::render('Pubsite', [
            'page' => $page
        ]);
    }
}
