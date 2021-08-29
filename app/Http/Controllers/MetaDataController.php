<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\Validator;

class MetaDataController extends Controller
{
    /**
     * MetaDataController constructor.
     *
     */
    public function __construct() {
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
