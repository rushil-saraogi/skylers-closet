<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClosetRequest;
use App\Http\Services\ClosetService;
use App\Models\Closet;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
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
     * Get the current user's pages
     *
     */
    public function dashboard(Request $request)
    {
        return Inertia::render('Dashboard', $this->getDashProps($request));
    }

    /**
     * Return the explore component
     *
     */
    public function explore()
    {
        return Inertia::render('Explore', []);
    }

    /**
     * Return the feed component
     *
     */
    public function feed()
    {
        return Inertia::render('Feed', []);
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

        return Inertia::render('Dashboard', array_merge(
            $this->getDashProps($request),
            [ 'selected' => $closet ]
        ));
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
     * Delete a page
     *
     * @param Request $request
     */
    public function delete(string $pageId)
    {
        $this->pageService->delete($pageId);

        return Redirect::route('dashboard');
    }

    private function getDashProps(Request $request)
    {
        $props = [
            'closets' => Closet::with('items')
                ->where('user_id', Auth::user()->id)
                ->get()
        ];

        if ($request->query('closet')) {
            $props['selected'] = $props['closets']->firstWhere('id', $request->query('closet'));
        }

        return $props;
    }

    public function pubsite(string $slug)
    {
        $page = Page::with('tiles')->where('slug', $slug)->first();
        
        return Inertia::render('Pubsite', [
            'page' => $page
        ]);
    }
}
