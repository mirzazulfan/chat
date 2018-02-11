<?php

use Faker\Factory as Faker;

trait MakeConversationTrait
{
    public function makeConversation($data = [])
    {
        return factory(\Musonza\Chat\Conversations\Conversation::class)->create();
    }
}