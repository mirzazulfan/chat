<?php

namespace Musonza\Chat\Policies;

use Musonza\Chat\Conversations\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    public function view($user, Conversation $conversation)
    {
        return $this->belongsToConversation($user, $conversation);
    }

    public function delete($user, Conversation $conversation)
    {
        return $this->belongsToConversation($user, $conversation);
    }

    private function belongsToConversation($user, Conversation $conversation)
    {
        return !!$conversation->users()->where('user_id', request()->user()->id)->first();
    }
}