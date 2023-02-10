<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{LessonPlan, Reports, Program};

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
            $class_id = $req->classid;

            $lessonPlan = LessonPlan::with('program', 'course')->whereRaw('FIND_IN_SET("' . $class_id . '", class_id)')->where(['course_id' => $req->course, 'lesson_plan.status' => 1])->orderBy('lesson_plan.lesson_no')->get();
            $report = Reports::where(['userid' => $userId, 'school' => $schoolId])->get('lesson_plan')->toArray();
            $complete_lesson = array_column($report, 'lesson_plan');
            $class_name = Program::find($class_id);

            $lessonplan_sort_list = DB::table('plan_sorting')->where(['course_id' => $req->course, 'class_id' => $class_id])->get(['lesson_id', 'position_order'])->toArray();

            foreach ($lessonPlan as $lessondata) {
                if (!empty($lessonplan_sort_list)) {
                    $sortKey = array_search($lessondata->id, array_column($lessonplan_sort_list, 'lesson_id'));
                    $postionId = $lessonplan_sort_list[$sortKey]->position_order;
                }else{
                    $postionId = 0;
                }
                $sortedList[$postionId] = $lessondata;
                $sortedList[$postionId]['position'] = $postionId;
            }
            $lessonPlan = collect($sortedList)->sortBy('position');
            return view('webpages.lessonplan', compact('lessonPlan', 'complete_lesson', 'class_id','class_name'));
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

    public static function getVideoUrl($video_src = "")
    {
        $parsed = parse_url($video_src);
        $checkUrlHost = explode('.', $parsed['host']);
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
}
