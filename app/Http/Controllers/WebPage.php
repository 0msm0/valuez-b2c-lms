<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LessonPlan;

class WebPage extends Controller
{
    public function courselist(Request $req)
    {
        $course = LessonPlan::join("master_course as mc", "mc.id", "=", "lesson_plan.course_id")
            ->where(['class_id' => $req->class, 'lesson_plan.status' => 1])
            ->groupBy('lesson_plan.course_id')
            ->orderBy('lesson_plan.id')
            ->selectRaw('lesson_plan.id,mc.course_name,mc.course_image,class_id,course_id')            
            ->get();
        return view('webpages.course', compact('course'));
    }

    public function lessonPlan(Request $req)
    {
        $lessonPlan = LessonPlan::with('program', 'course')->where(['course_id' => $req->course, 'class_id' => $req->classid, 'lesson_plan.status' => 1])->orderBy('lesson_plan.lesson_no')->get();
        return view('webpages.lessonplan', compact('lessonPlan'));
    }
}
