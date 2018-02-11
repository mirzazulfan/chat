<?php

$prefix = ''; // Chat::routesPrefix();

Route::group(['middleware' => []], function () use ($prefix) {
    Route::resource('conversations', 'Musonza\Chat\Http\Controllers\Front\ConversationController');
});
