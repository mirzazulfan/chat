<?php

use Faker\Generator as Faker;

$factory->define(Musonza\Chat\Conversations\Conversation::class, function (Faker $faker) {
    return [
        'private' => false
    ];
});
