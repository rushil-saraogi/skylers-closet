<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClosetRequest;
use App\Http\Services\ClosetService;
use App\Models\Closet;
use App\Models\Message;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClosetController extends Controller
{
    protected $closetService;

    /**
     * ClosetController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
        ClosetService $closetService
    ) {
        $this->closetService = $closetService;
    }

    /**
     * Render closet
     *
     * @param Request $request
     */
    public function show(Request $request, Closet $closet)
    {
        $closet = $closet->load('items', 'user');
        $owner = $closet->user;

        return Inertia::render('Closet', [
            'closet' => $closet,
            'messages' => Message::where('closet_id', $closet->id)
                ->whereNull('parent_message_id')
                ->with('replies.user', 'user', 'item')
                ->get(),
            'isFollowing' => $closet->followers->contains($owner),
            'user_closets' => $owner->closets->load('items', 'category')
        ]);
    }

    /**
     * Get current user's closets
     *
     * @param Request $request
     */
    public function currentUser(Request $request)
    {
        return Auth::user()->closets->load('items', 'category');
    }

    /**
     * Create a single page for the current user
     *
     * @param CreateClosetRequest $request
     */
    public function create(CreateClosetRequest $request)
    {
        $closet = $this->closetService->create(
            array_merge(
                $request->all(),
                [ 'user_id' => Auth::user()->id ]
            )
        );

        return Redirect::route('dashboard', [ 'closet' => $closet->id ]);
    }

    /**
     * Update a page
     *
     * @param Request $request
     */
    public function update(Request $request, Closet $closet)
    {
        $this->closetService->update($request->all(), $closet);

        return redirect()->back();
    }

    /**
     * Delete a Closet
     *
     * @param Request $request
     * @param Closet $closet
     */
    public function delete(Request $request, Closet $closet)
    {
        $this->closetService->delete($closet);

        return Redirect::route('dashboard');
    }

    /**
     * Follow closet
     *
     * @param Closet $closet
     */
    public function follow(Request $request, Closet $closet)
    {
        $this->closetService->follow($closet);
        return redirect()->back();
    }

    /**
     * Unfollow closet
     *
     * @param Closet $closet
     */
    public function unfollow(Request $request, Closet $closet)
    {
        $this->closetService->unfollow($closet);
        return redirect()->back();
    }
}
