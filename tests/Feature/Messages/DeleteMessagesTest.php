<?php

namespace Musonza\Chat\Tests\Feature\Conversations;

use Musonza\Chat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Chat;

class DeleteMessagesTest extends TestCase
{
    use \MakeConversationTrait;

    public function setUp()
    {
        parent::setUp();
        
        $this->sendMessage();
    }

    /** @test */
    function can_only_delete_your_messages()
    {
        $this->signIn();

        $this->json('DELETE', route('conversations.message.destroy', [$this->conversation->id, $this->message->id]))
             ->assertStatus(Response::HTTP_FORBIDDEN);
    }

       /** @test */
    function can_delete_your_message()
    {
        $this->signIn($this->conversation->users[0]);

        $this->json('DELETE', route('conversations.message.destroy', [$this->conversation->id, $this->message->id]))
             ->assertSuccessful();
    }
}