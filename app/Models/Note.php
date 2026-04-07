<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    //


    protected $fillable = [
            'name' ,
            'date',
            'url',
            'user_id',
    ];
}
