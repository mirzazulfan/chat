<?php 

namespace Musonza\Chat\Http\Controllers\Front;

use Musonza\Chat\Http\Controllers\Controller;
use Musonza\Chat\Conversations\UI\Requests\CreateConversationRequest;
use Musonza\Chat\Conversations\UI\Requests\ListConversationRequest;
use Musonza\Chat\Chat;
use Musonza\Chat\Conversations\Conversation;
use Musonza\Chat\Messages\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConversationMessagesController extends Controller
{
    /**
     * List messages in a conversation
     *
     * @param Conversation $conversation
     */
    public function index(Conversation $conversation)
    {
        $user = request()->user();

        return $this->chat->conversations($conversation)
                          ->for($user)
                          ->getMessages();
    }

    /**
     * Get message details
     *
     * @param Conversation $conversation
     * @param Message $message
     */
    public function show(Conversation $conversation, Message $message)
    {
        if (request()->user()->can('view', $conversation)) {
            return $message;
        }

        abort(403);
    }

    /**
     * Delete a message for user
     *
     * @param Conversation $conversation
     * @param Message $message
     */
    public function destroy(Conversation $conversation, Message $message)
    {
        $user = request()->user();

        if ($user->can('delete', $conversation)) {
            return $this->chat->messages($message)->for($user)->delete();
        }

        abort(403);
    }
}