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
        $this->json('GET',route('conversations.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function authenticated_user_can_list_their_conversations()
    {
        $this->sendMessage();

        $this->signIn($this->conversation->users[0]);

        $this->json('GET', route('conversations.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' =>[
                    [
                        'id' => 1,
                        'private' => false,
                        'last_message' => [
                            'id' => 1,
                            'message_id' => '1',
                            'conversation_id' => '1',
                            'user_id' => '1',
                            'is_seen' => '0',
                            'is_sender' => '0',
                            'type' => 'text',
                        ]
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'total'=> 1,
                        'count' => 1,
                        'per_page' => 25,
                        'current_page' =>1,
                        'total_pages' => 1,
                        'links' => []
                    ]
                ]
            ]);
    }

    /** @test */
    public function displays_details_of_specific_conversation_to_authorized_user()
    {
        $this->sendMessage();
        
        $this->signIn($this->conversation->users[0]);
        $this->json('GET', route('conversations.show', ['conversation' => $this->conversation->id]))
            ->assertSuccessful()
            ->assertJson([
                'id' => $this->conversation->id,
                'private' => false,
                'last_message' => [
                    'id' => 1,
                    'message_id' => '1',
                    'conversation_id' => '1',
                    'user_id' => '1',
                    'is_seen' => '0',
                    'is_sender' => '0',
                    'type' => 'text',
                ]
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