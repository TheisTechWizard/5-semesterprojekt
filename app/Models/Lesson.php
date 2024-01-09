<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id',
    ];
 
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function materials(){
        return $this->hasMany(Material::class);
    }
}
