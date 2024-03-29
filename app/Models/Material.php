<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'lesson_id',
    ];
 
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    public function lessons(){
        return $this->belongsTo(Lesson::class);
    }
}
