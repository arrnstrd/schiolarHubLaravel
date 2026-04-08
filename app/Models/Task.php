<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    // app/Models/Task.php
protected $fillable = [
        'task_name', 
        'due_date', 
        'subject', 
        'status', 
        'user_id'
    ];
}
