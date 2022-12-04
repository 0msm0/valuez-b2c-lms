<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    use HasFactory;
    protected $table = 'lesson_plan';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function program()
    {
        return $this->hasOne(Program::class, 'id', 'class_id');
    }

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}
