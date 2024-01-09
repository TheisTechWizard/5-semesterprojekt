<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class user_courses extends Pivot
{
    use HasFactory;

    protected $table = 'user_courses';

    protected $hidden = [
        'user_id',
        'course_id',
    ];

    protected $fillable = 'isCompleted';
}
