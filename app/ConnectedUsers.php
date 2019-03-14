<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectedUsers extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'connected_user'
    ];
}
