<?php

namespace App\Http\Services;

use App\Models\Message;
use App\Models\Closet;

class MessageService
{

    /**
     * ItemService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a tile
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

    /**
     * Update a tile
     *
     * @param array $data
     * @param Item $item
     * @return Item
     */
    public function update(array $data, Item $item): Item
    {
        // If the order is changing swap order values with the other item
        if (array_key_exists('item_order', $data) && $item->item_order !== $data['item_order']) {
            $originalItemInOrder = $item
                ->closet->items
                ->where('item_order', $data['item_order'])
                ->first();
            
            if (!$originalItemInOrder) {
                throw new \Exception('Invalid order value');
            }

            $originalItemInOrder->item_order = $item->item_order;
            $originalItemInOrder->save();
        }

        $item->fill($data);
        $item->save();
        return $item;
    }

    /**
     * Delete a link
     *
     * @param Item $item
     * @return void
     */
    public function delete(Item $item): void
    {
        $item->delete();

        // Fix the item order after a deletion
        Item::where('item_order', '>', $item->item_order)->decrement('item_order', 1);
    }

    /**
     * Get the order for a new item
     * Orders starts at 0
     *
     * @param Closet $closet
     * @return int
     */
    private function getHighestOrder(Closet $closet): int
    {
        if (!$closet->items()->exists()) {
            return 0;
        }

        return max(
            $closet->items->pluck('item_order')->toArray()
        ) + 1;
    }
}
