<?php

namespace Musonza\Chat\Http\Controllers\Front;

use Musonza\Chat\Http\Controllers\Controller;
use Musonza\Chat\Http\Requests\CreateConversationRequest;
use Musonza\Chat\Http\Requests\ListConversationRequest;
use Musonza\Chat\Conversations\Conversation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConversationController extends  Controller
{
    /**
     * List Conversations for user
     *
     * @param ListConversationRequest $request
     */
    public function index(ListConversationRequest $request)
    {
        $paginator = $this->chat->conversations()
                    ->for($request->user())
                    ->page($request->page)
                    ->get();

        $this->setPaginator($paginator, $request);
           
        return $this->conversationTransformer->transformCollection($this->collection, $paginator);
    }

    /**
     * Start a new Conversation
     *
     * @param CreateConversationRequest $request
     * @return Conversation
     */
    public function store(CreateConversationRequest $request)
    {
        return $this->chat->createConversation($request->participants); 
    }

    /**
     * Get conversation
     *
     * @param int $id
     */
    public function show($id)
    {
        $conversation = Conversation::findOrFail($id);

        if (request()->user()->can('view', $conversation)) {
            return $this->conversationTransformer->transformItem($conversation->includeLastMessage());
        }

        abort(403);
    }

    /**
     * Clear a Conversation
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);

        if (request()->user()->can('delete', $conversation)) {
           $this->chat->conversations($conversation)->for(request()->user())->clear();

           return response([], Response::HTTP_NO_CONTENT);
        }

        abort(403);
    }
}