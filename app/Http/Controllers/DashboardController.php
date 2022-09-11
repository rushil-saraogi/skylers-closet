<?php

namespace App\Http\Controllers;

use App\Models\Closet;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
    public function dashboard(Request $request)
    {
        return Inertia::render('Dashboard', $this->getDashProps($request));
    }

    /**
     * Return the explore component
     *
     */
    public function explore(Request $request)
    {
        $props = [
            'categories' => Category::all(),
        ];


        $props['selected'] = $request->query('category')
            ? $props['categories']->firstWhere('id', $request->query('category'))
            :  $props['categories']->first();
        
        $props['closets'] = Closet::where('category_id', $props['selected']->id)
            ->with('category')
            ->with('items')
            ->get();

        return Inertia::render('Explore', $props);
    }

    /**
     * Return the feed component
     *
     */
    public function feed()
    {
        return Inertia::render('Feed', []);
    }

    private function getDashProps(Request $request)
    {
        $props = [
            'closets' => Closet::with('items')
                ->with('category')
                ->where('user_id', Auth::user()->id)
                ->get(),
            'categories' => Category::all(),
        ];

        if ($request->query('closet')) {
            $props['selected'] = $props['closets']->firstWhere('id', $request->query('closet'));
        }

        return $props;
    }
}
