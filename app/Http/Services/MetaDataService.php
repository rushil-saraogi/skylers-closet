<?php

namespace App\Http\Services;

use Goutte\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use OpenGraph;

class MetaDataService
{
    protected $client;
    /**
     * MetaDataService constructor.
     *
     */
    public function __construct() {
        $this->client = new Client();
    }

    /**
     * Get socal meta data for URL
     *
     * @param Request $request
     */
    public function getMetaData(string $url)
    {
        $strippedUrl = explode('?', $url)[0];

        if ($this->isAmazonUrl($url)) {
            $metaData = $this->getAmazonData($strippedUrl);
        } else {
            $crawler = $this->client->request('GET', $strippedUrl);

            $metaData = [
                'title' => $this->getTitle($crawler),
                'image' => $this->getMetaValue($crawler, "meta[property='og:image']"),
            ];
        }

        return response()->json($metaData);
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

    private function isAmazonUrl($url)
    {
        return preg_match('/www\.amazon/', $url);
    }

    private function getAmazonData($url)
    {
        preg_match('/\/(dp|o|gp)\/(B[A-Z0-9]{9})/', $url, $asin_arr);

        $asin = $asin_arr[2];

        // Using Rapid API for Amazon requests because Amazon refuses to make me an affiliate
        $response = Cache::has($url)
            ? Cache::get($url)
            : Http::withHeaders([
                'X-RapidAPI-Key' => config('services.rapid_api.key'),
                'X-RapidAPI-Host' => 'amazon23.p.rapidapi.com'
            ])->get('https://amazon23.p.rapidapi.com/product-details', [
                'asin' => $asin,
                'country' => 'US'
            ])->body();
        
        $response = preg_replace('/(\x{200e}|\x{200f})/u', '', $response);

        Cache::put($url, $response, now()->addMinutes(60 * 24)); // Cache Amazon responses for 24 hours
        
        $productData = json_decode($response)->result[0];

        return [
            'image' => $productData->main_image,
            'title' => $productData->title,
            'price' => $productData->price->current_price,
            'asin' => $productData->asin,
            'url' => $productData->url,
            'rating' => $productData->reviews->rating,
            'model' => $productData->product_information->manufacturer,
            'brand' =>  $productData->product_information->brand,
        ];
    }
}
