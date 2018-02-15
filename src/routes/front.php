<?php

$prefix = ''; // Chat::routesPrefix();

Route::group(['middleware' => ['bindings']], function () use ($prefix) {
    Route::resource('conversations', 'Musonza\Chat\Http\Controllers\Front\ConversationController');
    Route::resource('conversations.message', 'Musonza\Chat\Http\Controllers\Front\ConversationMessagesController');
});

/*

********************************************************************************************

POST      /conversations              - start conversation
---------------------------------------------------------------------------------------------
GET      /conversations               - list user conversations
filters:
common among users
private / group chats
---------------------------------------------------------------------------------------------
GET     /consversations/1             - get conversation details
filters:
unread messages
read messages
exclude - messages, users
include - users
---------------------------------------------------------------------------------------------
DELETE /consversations/1              - clear conversation

********************************************************************************************

POST      /conversations/1/message    - create a message
---------------------------------------------------------------------------------------------
GET      /conversations/1/message/23  - get a specific message in a conversation
---------------------------------------------------------------------------------------------
GET     /consversations/1/message     - get conversation messages
---------------------------------------------------------------------------------------------
DELETE /consversations/1/message/23   - delete a specific message from a conversation for logged in user


********************************************************************************************


*/