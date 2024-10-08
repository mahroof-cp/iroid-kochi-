<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class_id', 'email', 'phone', 'avatar'];


    //https://www.itsolutionstuff.com/post/laravel-9-ajax-crud-tutorial-exampleexample.html
}
