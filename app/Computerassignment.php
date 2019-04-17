<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computerassignment extends Model
{
    protected $fillable = [
        'visitor_id', 'computer_id', 'open','close',
    ];
}
