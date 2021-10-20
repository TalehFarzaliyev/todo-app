<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todolist';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
