<?php

namespace App\Http\Services;

use App\Models\Message;
use App\Models\Closet;

class MessageService
{

    /**
     * MessageService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a message
     *
     * @param array $data
     * @return array
     */
    public function create(array $data, Closet $closet)
    {
        $closet->messages()->create(
            array_merge(
                $data,
                [ 'closet_id' => $closet->id ]
            )
        );
    }
}
