<?php

namespace App\Http\Controllers;

use App\Http\Services\LinkService;
use App\Models\Page;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\Validator;
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
        $page = Page::find($pageId);
        $this->linkService->create($request->all(), $page);

        return Inertia::render('PageEditor', [
            'page' => Page::find($pageId)
                ->with('links')
                ->get()
                ->toArray()[0]
        ]);
    }

    /**
     * Get socal meta data for URL
     *
     * @param Request $request
     */
    public function getMetaData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|URL',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $url = $request->url;
        $client = new Client();
        $crawler = $client->request('GET', $url);

        return response()->json([
            'title' => $this->getTitle($crawler),
            'description' => $this->getMetaValue($crawler, "meta[name='description']"),
            'og_title' => $this->getMetaValue($crawler, "meta[property='og:title']"),
            'og_description' => $this->getMetaValue($crawler, "meta[property='og:description']"),
            'og_image' => $this->getMetaValue($crawler, "meta[property='og:image']"),
        ]);
    }

    private function getMetaValue($crawler, $selector)
    {
        $nodes = $crawler->filter($selector);
        return count($nodes) > 0 ? $crawler->filter($selector)->eq(0)->attr('content') : '';
    }

    private function getTitle($crawler)
    {
        return $crawler->filter('title')->eq(0)->text();
    }
}
