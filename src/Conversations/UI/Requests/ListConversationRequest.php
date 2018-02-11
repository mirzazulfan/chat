<?php

namespace Musonza\Chat\Conversations\UI\Requests;

use Musonza\Chat\Http\Requests\ChatRequest;

class ListConversationRequest extends ChatRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}