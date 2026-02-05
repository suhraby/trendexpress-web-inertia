<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'subject',
        'name',
        'surname',
        'email',
        'phone_number',
        'body',
        'is_read',
        'user_ip',
        'user_agent',
    ];
}
