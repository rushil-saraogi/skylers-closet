<?php

namespace App\Http\Controllers;

use App\Models\Closet;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * ClosetController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
    ) {
    }

    /**
     * Get the current user's pages
     *
     */
    public function UserProfile(Request $request, User $user)
    {
        return Inertia::render('UserProfile', [
            'user' => $user->load('closets'),
        ]);
    }
}
