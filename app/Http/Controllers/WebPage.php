<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebPage extends Controller
{
    public function courselist(Request $req)
    {
        $course = DB::table('lesson_plan')
            ->join("master_course as mc", "mc.id", "=", "course_id")
            ->where(['class_id' => $req->class, 'lesson_plan.status' => 1])->orderBy('lesson_plan.id')
            ->selectRaw('lesson_plan.id as lesson_id,mc.course_name,mc.course_image')
            ->get();
        return view('webpages.course', compact('course'));
    }

    public function lessonPlan(Request $req)
    {
        $lessonPlan = DB::table('lesson_plan')
            ->where(['id' => $req->id, 'lesson_plan.status' => 1])->orderBy('lesson_plan.lesson_no')
            ->get();

        return view('webpages.lessonplan', compact('lessonPlan'));
    }
}
