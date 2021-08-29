<?php

namespace App\Http\Controllers;

use App\Http\Services\LinkService;
use App\Models\Link;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LinkController extends Controller
{
    /**
     * LinkController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
        LinkService $linkService
    ) {
        $this->linkService = $linkService;
    }

    /**
     * Create a single Link for a page
     *
     * @param Request $request
     */
    public function create(Request $request, string $pageId)
    {
        $validated = $this->validateLink($request);
        $page = Page::find($pageId);
        $this->linkService->create($validated, $page);
        return Redirect::route('page-editor', $pageId);
    }

    /**
     * Update a single Link for a page
     *
     * @param Request $request
     */
    public function update(Request $request, string $pageId, string $linkId)
    {
        $validated = $this->validateLink($request);
        $link = Link::find($linkId);
        $this->linkService->update($validated, $link);
        return Redirect::route('page-editor', $pageId);
    }

    /**
     * Delete a single Link for a page
     *
     * @param Request $request
     */
    public function delete(Request $request, string $pageId, string $linkId)
    {
        $link = Link::find($linkId);
        $this->linkService->delete($link);
        return Redirect::route('page-editor', $pageId);
    }

    /**
     * Validate Link data
     *
     * @param Request $request
     */
    private function validateLink(Request $request)
    {
        return $request->validate([
            'url' => ['required', 'URL'],
            'name' => ['required', 'string'],
            'color' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'title' => ['string', 'nullable'],
            'animated' => ['boolean'],
            'og_title' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'og_description' => ['string', 'nullable'],
            'og_image' => ['URL', 'nullable'],
        ]);
    }
}
