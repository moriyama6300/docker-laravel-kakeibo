<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    protected $fillable = [
        'date', 'category','yen'
    ];
}
