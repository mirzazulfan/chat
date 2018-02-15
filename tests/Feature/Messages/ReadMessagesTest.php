<?php

namespace Musonza\Chat\Tests\Feature\Conversations;

use Musonza\Chat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Chat;

class ReadMessagesTest extends TestCase
{
    use \MakeConversationTrait;

    public function setUp()
    {
        parent::setUp();
        
        $this->sendMessage();
    }

    /** @test */
    function displays_details_of_specific_message()
    {
        $this->signIn($this->conversation->users[0]);

        $this->json('GET', route('conversations.message.show', [$this->conversation->id, $this->message->id]))
             ->assertSuccessful();
    }

    /** @test */
    function can_only_see_message_you_are_part_of()
    {
        $this->signIn();

        $this->json('GET', route('conversations.message.show', [$this->conversation->id, $this->message->id]))
             ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function list_messages_in_a_conversation()
    {
        $this->signIn($this->conversation->users[0]);

        $this->json('GET', route('conversations.message.index', [$this->conversation->id]))
            ->assertSuccessful();
    }
}