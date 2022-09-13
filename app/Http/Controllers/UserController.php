<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Services\UserService;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Get user profile
     *
     */
    public function UserProfile(Request $request, User $user)
    {
        return Inertia::render('UserProfile', [
            'user' => $user->load('closets.items', 'followers', 'follows'),
        ]);
    }

    /**
     * Logged in user follows another user
     *
     */
    public function follow(Request $request, User $user)
    {
        if (Auth::user()->id === $user->id) {
            throw new Exception("Can't follow yourself dummy");
            return;
        }

        $this->userService->follow($user);
        return redirect()->back();
    }

    public function unfollow(Request $request, User $user)
    {
        $this->userService->unfollow($user);
        return redirect()->back();
    }
}
