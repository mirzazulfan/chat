<?php

namespace Musonza\Chat;

use Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Musonza\Chat\Conversations\Conversation;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = ['password', 'remember_token'];

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}