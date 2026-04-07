<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    // app/Models/Task.php
protected $fillable = ['user_id', 'task_name', 'subject', 'due_date', 'status'];
}
