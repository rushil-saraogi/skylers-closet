<?php

namespace App\Actions\Fortify;

use App\Http\Services\ClosetService;
use App\Http\Services\ItemService;
use App\Models\User;
use App\Models\Closet;
use App\Models\Item;
use App\Models\GlobalItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected ClosetService $closetService;
    protected ItemService $itemService;

    public function __construct(
        ClosetService $closetService,
        ItemService $itemService
    ) {
        $this->closetService = $closetService;
        $this->itemService = $itemService;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $closet = $this->closetService->create([
            'name' => $user->name . "'s closet",
            'user_id' => $user->id,
        ]);

        // The first 3 are seeded with random items, grabbing one
        $randomGlobalItem = GlobalItem::take(3)->get()->random(1)->first();

        $this->itemService->create([
            'title' => $randomGlobalItem->title,
            'image' => $randomGlobalItem->image,
            'price' => $randomGlobalItem->price,
            'url' => $randomGlobalItem->url,
            'asin' => $randomGlobalItem->asin,
            'closet_id' => $closet->id,
        ], $closet);

        return $user;
    }
}
