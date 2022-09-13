<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserService
{

    /**
     * UserService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Follow user
     *
     * @param User $user
     * @return array
     */
    public function follow(User $user)
    {
        $user->followers()->attach(Auth::user());
    }

    /**
     * Follow user
     *
     * @param User $user
     * @return array
     */
    public function unfollow(User $user)
    {
        $user->followers()->detach(Auth::user());
    }
}
