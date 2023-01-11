<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Services\UserService;
use App\Models\User;
use App\Models\Hotel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
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
     * Add new user
     *
     * @param CreateUserRequest $request
     */
    public function create(CreateUserRequest $request, Hotel $hotel)
    {
        $this->userService->create($request->all());
    return redirect()->back();
    }

    /**
     * Get user profile
     *
     */
    public function UserProfile(Request $request, User $user)
    {
        return Inertia::render('UserProfile', [
            // 'user' => $user->load('closets.items', 'closets.user'),
            'user' => $user,
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

    public function completeOnboarding(Request $request, User $user)
    {
        $this->userService->completeOnboarding($user);
        return redirect()->back();
    }
}
