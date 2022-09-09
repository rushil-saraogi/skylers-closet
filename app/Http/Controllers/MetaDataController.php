<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\MetaDataService;

class MetaDataController extends Controller
{
    protected $metaDataService;

    /**
     * MetaDataController constructor.
     *
     */
    public function __construct(MetaDataService $metaDataService)
    {
        $this->metaDataService = $metaDataService;
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

        return $this->metaDataService->getMetaData($url);
    }
}
