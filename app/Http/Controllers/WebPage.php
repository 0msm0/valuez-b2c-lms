<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{LessonPlan, Reports, Program, School};

class WebPage extends Controller
{
    public function courselist(Request $req)
    {
        $user = Auth::user();
        $userId = $user->id;
        $schoolId = $user->school_id;
        $classId = $req->class;
        $class_name = Program::find($classId);
        $course = LessonPlan::join("master_course as mc", "mc.id", "=", "lesson_plan.course_id")
            ->whereRaw('FIND_IN_SET("' . $classId . '", class_id)')
            ->where(['lesson_plan.status' => 1])
            ->groupBy('lesson_plan.course_id')
            ->orderBy('lesson_plan.id')
            ->selectRaw('count(lesson_plan.id) as total_plan,mc.course_name,mc.course_image,class_id,course_id')
            ->get();
        return view('webpages.course', compact('course', 'classId','userId','class_name'));
    }

    public function lessonPlan(Request $req)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $schoolId = $user->school_id;
            $class_id = $req->classid;

            $lessonPlan = LessonPlan::with('program', 'course')
                ->leftJoin('plan_sorting', 'plan_sorting.lesson_id', '=', 'lesson_plan.id')
                ->groupBy('lesson_plan.id')
                ->whereRaw('FIND_IN_SET("' . $class_id . '", lesson_plan.class_id)')->where(['lesson_plan.course_id' => $req->course, 'lesson_plan.status' => 1])->selectRaw('lesson_plan.*,plan_sorting.position_order')->orderBy('plan_sorting.position_order')->get();

            $report = Reports::where(['userid' => $userId, 'school' => $schoolId, 'classId' => $class_id])->get('lesson_plan')->toArray();
            $complete_lesson = array_column($report, 'lesson_plan');
            $class_name = Program::find($class_id);
            $check_premium = School::find($schoolId);

            return view('webpages.lessonplan', compact('lessonPlan', 'complete_lesson', 'class_id', 'class_name', 'check_premium'));
        }
    }

    public function setUserReport(Request $req)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $schoolId = $user->school_id;
            $userType = $user->usertype;
            $classId = $req->gradeId;

            if ($userType == 'teacher') {
                $addReport = ['userid' => $userId, 'school' => $schoolId, 'lesson_plan' => $req->planId, 'classId' => $classId];
                Reports::updateOrCreate($addReport);
                return "update";
            } else {
                return "error";
            }
        }
    }

    public static function getVideoUrl($video_src = "")
    {
        $parsed = parse_url($video_src);
        $checkUrlHost = isset($parsed['host'])?explode('.', $parsed['host']):[];
        if (in_array('youtube', $checkUrlHost)) {
            $video_id = explode('?v=', $video_src);
            if (empty($video_id[1])) {
                $video_id = explode('/v/', $video_src);
            }
            $video_id = explode('&', $video_id[1]);
            $video_id = $video_id[0];
            $video_url = 'https://www.youtube.com/embed/' . $video_id;
        } elseif (in_array('vimeo', $checkUrlHost)) {
            $parse_vimeo = parse_url($video_src, PHP_URL_PATH);
            $video_id = array_values(array_filter(explode('/', $parse_vimeo)));
            $para_vimeo = count($video_id) > 1 ? '?h=' . $video_id[1] : '';
            $video_url = 'https://player.vimeo.com/video/' . $video_id[0] . $para_vimeo;
        } else {
            $video_url = '';
        }
        return $video_url;
    }

    /**public page */
    public function getDemo(Request $req)
    {
        return view('webpages.get-demo');
    }
}
