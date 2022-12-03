<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{LessonPlan, Reports};

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
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $schoolId = $user->school_id;
            $lessonPlan = LessonPlan::with('program', 'course')->where(['course_id' => $req->course, 'class_id' => $req->classid, 'lesson_plan.status' => 1])->orderBy('lesson_plan.lesson_no')->get();
            $report = Reports::where(['userid' => $userId,'school'=>$schoolId])->get('lesson_plan')->toArray();
            $complete_lesson = array_column($report,'lesson_plan');
            return view('webpages.lessonplan', compact('lessonPlan', 'complete_lesson'));
        }
    }

    public function setUserReport(Request $req)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $schoolId = $user->school_id;
            $userType = $user->usertype;
            if ($userType == 'teacher') {
                $addReport = ['userid' => $userId, 'school' => $schoolId, 'lesson_plan' => $req->planId];
                Reports::updateOrCreate($addReport);
                return "update";
            } else {
                return "error";
            }
        }
    }
}
