<?php

namespace Musonza\Chat\Tests\Feature\Conversations;

use Musonza\Chat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateConversationTest extends TestCase
{
   /** @test */
    function guests_may_not_start_a_conversation()
    {
        $this->json('POST',route('conversations.store'), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function a_user_can_start_a_conversation()
    {
        $this->signIn();

        $data = ['participants' => $this->participants(3)];

        $this->json('POST', route('conversations.store'), $data)
            ->assertSuccessful()
            ->assertJson([
                'private' => false,
                'id' => 1
            ]);
    }
}