<?php

namespace Musonza\Chat\Tests\Feature\Conversations;

use Musonza\Chat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Chat;

class ReadConversationsTest extends TestCase
{
    use \MakeConversationTrait;

    /** @test */
    function guests_may_not_list_conversations()
    {
        $conversation = $this->makeConversation();

        Chat::addParticipants($conversation, $this->participants(3)); 

        $this->json('GET',route('conversations.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function authenticated_user_can_list_their_conversations()
    {
        $conversation = $this->makeConversation();

        Chat::addParticipants($conversation, $this->participants(3)); 

        Chat::message('Hello')
            ->from(1)
            ->to($conversation)
            ->send(); 

        $this->signIn($conversation->users[0]);

        $this->json('GET', route('conversations.index'))
            ->assertSuccessful()
            ->assertJson([
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 25,
                'last_page_url' => 'http://localhost/conversations?page=1',
                'next_page_url' => null,
                'path' => 'http://localhost/conversations',
                'total' => 1,
                'data' => [
                    [
                        'private' => false,
                        'last_message' => [
                            'body' => 'Hello',
                            'type' => 'text',
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function displays_details_of_specific_conversation_to_authorized_user()
    {
        $conversation = $this->makeConversation();

        Chat::addParticipants($conversation, [$this->users[0]]); 

        $this->signIn($this->users[0]);

        $this->json('GET', route('conversations.show', ['conversation' => $conversation->id]))
            ->assertSuccessful()
            ->assertJson([
                'id' => $conversation->id
            ]);
    }

    /** @test */
    public function unauthorized_users_can_not_see_conversations()
    {
        $conversation = $this->makeConversation();

        Chat::addParticipants($conversation, [$this->users[0]]); 

        $this->signIn();

        $this->json('GET', route('conversations.show', ['conversation' => $conversation->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}