<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'course_id',
        'pivot',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')
            ->withPivot(['isCompleted', 'deadline_at']);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
