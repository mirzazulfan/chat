<?php

namespace Musonza\Chat\Conversations\Policies;

use Musonza\Chat\Conversations\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    public function view($user, Conversation $conversation)
    {
        return !!$conversation->users()->where('user_id', request()->user()->id)->first();
    }
}