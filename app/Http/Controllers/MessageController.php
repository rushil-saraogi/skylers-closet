<?php

namespace App\Http\Controllers;

use App\Http\Services\MessageService;
use App\Models\Message;
use App\Models\Closet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected MessageService $messageService;

    /**
     * MessageController constructor.
     *
     * @param PageService $pageService
     */
    public function __construct(
        MessageService $messageService
    ) {
        $this->messageService = $messageService;
    }

    /**
     * Add an message to a closet
     *
     * @param Request $request
     */
    public function create(Request $request, Closet $closet)
    {
        $validated = $this->validatemessage($request);
        $validated['user_id'] = Auth::user()->id;
        $this->messageService->create($validated, $closet);
        return redirect()->back();
    }

    /**
     * Update a single Tile for a page
     *
     * @param Request $request
     */
    public function update(Request $request, Closet $closet, Message $message)
    {
        $validated = $this->validatemessage($request);
        $this->messageService->update($validated, $message);
        return redirect()->back();
    }

    /**
     * Update a single Tile for a page
     *
     * @param Request $request
     */
    public function updateWithoutIntertia(Request $request, Closet $closet, Message $message)
    {
        $validated = $this->validatemessage($request);
        $message = $this->messageService->update($validated, $message);
        return response()->json($message);;
    }

    /**
     * Delete a single Tile for a page
     *
     * @param Request $request
     */
    public function delete(Request $request, Closet $closet, message $message)
    {
        $this->messageService->delete($message);
        return redirect()->back();
    }

    /**
     * Validate Tile data
     *
     * @param Request $request
     */
    private function validatemessage(Request $request)
    {
        return $request->validate([
            'message_body' => ['required', 'string'],
            'item_id' => ['nullable', 'integer'],
            'parent_message_id' => ['nullable', 'integer'],
        ]);
    }
}
