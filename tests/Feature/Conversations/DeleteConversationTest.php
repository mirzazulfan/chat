<?php

namespace Musonza\Chat\Tests\Feature\Conversations;

use Musonza\Chat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Chat;

class DeleteConversationTest extends TestCase
{
    use \MakeConversationTrait;

   /** @test */
    function unauthorized_user_may_not_clear_a_conversation()
    {
        $conversation = $this->makeConversation();

        $this->signIn();

        $this->json('DELETE',route('conversations.destroy', [$conversation->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function authorized_user_may_clear_a_conversation()
    {
        $conversation = $this->makeConversation();

        Chat::addParticipants($conversation, $this->participants(3)); 

        $this->signIn($conversation->users[0]);

        $this->json('DELETE',route('conversations.destroy', [$conversation->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}