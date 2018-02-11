<?php

namespace Musonza\Chat\Http\Controllers\Front;

use Musonza\Chat\Http\Controllers\Controller;
use Musonza\Chat\Conversations\UI\Requests\CreateConversationRequest;
use Musonza\Chat\Conversations\UI\Requests\ListConversationRequest;
use Musonza\Chat\Chat;
use Musonza\Chat\Conversations\Conversation;
use Illuminate\Http\Request;

class ConversationController extends  Controller
{
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function index(ListConversationRequest $request)
    {
        return $this->chat->conversations()
                    ->for($request->user())
                    ->page($request->page)
                    ->get();
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

    public function show($id)
    {
        $conversation = Conversation::findOrFail($id);

        if (request()->user()->can('view', $conversation)) {
           return $conversation;
        }

        abort(403);
    }
}