<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [

         'user_id',

      'request_id',

        'title',

      'message',

       'type',

       'action_url',

       'is_read'
        

    ];

    public function user()
{
    return $this->belongsTo(
        User::class,
        'user_id',
        'id'
    );
}
}