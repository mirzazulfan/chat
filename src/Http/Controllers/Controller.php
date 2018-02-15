<?php

namespace Musonza\Chat\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Musonza\Chat\Chat;
use Musonza\Chat\Transformers\ConversationTransformer;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Chat $chat, ConversationTransformer $conversationTransformer)
    {
        $this->chat = $chat;
        $this->conversationTransformer = $conversationTransformer;
    }

    public function setPaginator($paginator, $request)
    {
        $collection = $paginator->getCollection();
        $queryParams = array_diff_key($request->all(), array_flip(['page', 'limit']));
        $paginator->appends($queryParams);
        $this->paginator = $paginator;
        $this->collection = $collection;

        return $this;
    }
}