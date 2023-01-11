<?php

namespace App\Http\Services;

use App\Models\AppDesign;
use Exception;

class AppDesignService
{
    protected $client;
    /**
     * AppDesignService constructor.
     *
     */
    public function __construct() {
        
    }

    /**
     * Create a new app design
     *
     * @param array $data
     * @return AppDesign
     */
    public function create(array $data): AppDesign
    {
        $appDesign = new AppDesign();
        $appDesign->fill($data);

        if (!$appDesign->save()) {
            throw new Exception('Hotel could not be saved.');
        }

        return $appDesign;
    }

}
