<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\SearchService;

class SearchController extends Controller
{
    protected $searchService;

    /**
     * SearchController constructor.
     *
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Get socal meta data for URL
     *
     * @param Request $request
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'queryString' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $queryString = $request->queryString;

        return $this->searchService->search($queryString);
    }
}
