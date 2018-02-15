<?php

namespace Musonza\Chat\Transformers;

class ConversationTransformer extends Transformer
{
    public function transform($conversation)
    {
        return $conversation->toArray();
    }
}