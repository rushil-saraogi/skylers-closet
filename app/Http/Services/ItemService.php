<?php

namespace App\Http\Services;

use App\Models\Item;
use App\Models\Closet;
use Illuminate\Support\Facades\DB;

class ItemService
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
        if (!array_key_exists('item_order', $data) || is_null($data['item_order'])) {
            $data['item_order'] = $this->getHighestOrder($closet);
        }

        $closet->items()->create(
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
    public function update(array $data, Closet $closet, Item $item): Item
    {
        DB::transaction(function () use ($data, $item, $closet) {
            // If the order is being changed update all other items to reflect
            if (array_key_exists('item_order', $data) && $data['item_order'] !== $item->item_order) {
                $newPosition = $data['item_order'];
                $oldPosition = $item->item_order;

                if ($newPosition < $oldPosition) {
                    Item::where('item_order', '>=', $newPosition)
                        ->where('item_order', '<=', $oldPosition)
                        ->where('id', '!=', $item->id)
                        ->where('closet_id', $closet->id)
                        ->increment('item_order', 1);
                } else {
                    Item::where('item_order', '>=', $oldPosition)
                        ->where('item_order', '<=', $newPosition)
                        ->where('id', '!=', $item->id)
                        ->where('closet_id', $closet->id)
                        ->decrement('item_order', 1);
                }
            }
    
            $item->fill($data);
            $item->save();
        });
        
        return $item;
    }

    /**
     * Delete a link
     *
     * @param Item $item
     * @return void
     */
    public function delete(Closet $closet, Item $item): void
    {
        $item->delete();

        // Fix the item order after a deletion
        Item::where('item_order', '>', $item->item_order)
            ->where('closet_id', $closet->id)
            ->decrement('item_order', 1);
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
