<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{Course, LessonPlan, Program};
use DataTables;

class LessonPlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lessonplan = LessonPlan::query()->join('master_class', 'master_class.id', '=', 'lesson_plan.class_id')
                ->join('master_course', 'master_course.id', '=', 'lesson_plan.course_id')
                ->select('lesson_plan.*', 'master_class.class_name', 'master_course.course_name');
            return Datatables::of($lessonplan)
                ->addIndexColumn()
                ->editColumn('lesson_image', function ($row) {
                    $ImagePath = $row->lesson_image ? $row->lesson_image : 'no_image.png';
                    return '<img src="' . url('uploads/lessonplan/' . $ImagePath) . '" width="32" height="32" class="bg-light my-n1"
                    alt="' . $row->title . '">';
                })
                ->editColumn('status', function ($row) {
                    $span_btn = '<span class="badge bg-' . ($row->status == 1 ? 'success' : 'danger') . '">' . ($row->status == 1 ? 'Active' : 'Inactive') . '</span>';
                    return $span_btn;
                })
                ->editColumn('is_demo', function ($row) {
                    $demo_btn = '<a href="javascript:void(0);"  id="status_' . $row->id . '" data-id="' . $row->id . '" data-status="' . $row->is_demo . '" class="change_status text-white badge bg-' . ($row->is_demo == 1 ? 'success' : 'danger') . '">' . ($row->is_demo == 1 ? 'Yes' : 'No') . '</a>';
                    return $demo_btn;
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="' . route('lesson.plan.edit', ['lessonplan' => $row->id]) . '"
                    class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Edit</a>';
                    $user = Auth::user();
                    $remove_btn = ($user->usertype == "superadmin") ? ' <a href="' . route('lesson.plan.remove', ['lessonplan' => $row->id]) . '"
                    class="waves-effect waves-light btn btn-sm btn-outline btn-danger mb-5">Delete</a>' : '';
                    $action_btn = $edit_btn . $remove_btn;
                    return $action_btn;
                })

                ->rawColumns(['action', 'is_demo', 'lesson_image', 'status'])
                ->make(true);
        }
        $class_list = Program::where('status', 1)->get();
        $course_list = Course::where('status', 1)->get();
        return view('lessonplan.lessonplan', compact('class_list', 'course_list'));
    }

    public function addlessonplan()
    {
        $program_list = DB::table('master_class')->where('status', 1)->get();
        $course_list = DB::table('master_course')->where('status', 1)->get();
        return view('lessonplan.lessonplan-add', compact('program_list', 'course_list'));
    }

    public function editlessonplan(Request $request)
    {
        $lessonId = $request->input('lessonplan');
        $lessonplan = DB::table('lesson_plan')->where('id', $lessonId)->first();
        $program_list = DB::table('master_class')->where('status', 1)->get();
        $course_list = DB::table('master_course')->where('status', 1)->get();

        return view('lessonplan.lessonplan-edit', compact('program_list', 'course_list', 'lessonplan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'video_url' => 'required',
            'lesson_no' => 'required',
            'class_id' => 'required',
            'course_id' => 'required',
            'image' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/lessonplan/';
            $originalname = $image->hashName();
            $imageName = "plan_" . date('Ymd') . '_' . $originalname;
            $image->move($destinationPath, $imageName);
        }

        $courseData = [
            'title' => $request->title,
            'video_url' => $request->video_url,
            'video_info_url' => $request->video_info_url,
            'lesson_no' => $request->lesson_no,
            'lesson_desc' => $request->lesson_desc,
            'class_id' => implode(",", $request->class_id),
            'course_id' => $request->course_id,
            'status' => $request->status,
            'lesson_image' => $imageName
        ];
        // print_r($courseData); die;
        LessonPlan::create($courseData);
        return redirect(route('lesson.plan.list'))->with(['message' => 'Lesson Plan added successfully!', 'status' => 'success']);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'video_url' => 'required',
            'lesson_no' => 'required',
            'class_id' => 'required',
            'course_id' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/lessonplan/';
            $originalname = $image->hashName();
            $imageName = "plan_" . date('Ymd') . '_' . $originalname;
            $image->move($destinationPath, $imageName);
            $image_path = $destinationPath . $request->old_image;
            @unlink($image_path);
        } else {
            $imageName = $request->old_image;
        }

        $courseData = [
            'title' => $request->title,
            'video_url' => $request->video_url,
            'video_info_url' => $request->video_info_url,
            'lesson_no' => $request->lesson_no,
            'lesson_desc' => $request->lesson_desc,
            'class_id' => implode(",", $request->class_id),
            'course_id' => $request->course_id,
            'status' => $request->status,
            'lesson_image' => $imageName
        ];
        // print_r($courseData); die;
        LessonPlan::where('id', $request->id)->update($courseData);
        return redirect(route('lesson.plan.list'))->with(['message' => 'Lesson Plan updated successfully!', 'status' => 'success']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $lessonId = $request->input('lessonplan');
        $user = Auth::user();
        if (($user) && $user->usertype == "superadmin") {
            DB::table('lesson_plan')->where('id', $lessonId)->delete();
            return redirect(route('lesson.plan.list'))->with('success', 'Lesson Plan deleted successfully');
        }
    }

    public function sortLessonPlan(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->type;
            if ($type == 'grade') {
                $courseId = $request->courseid;
                $class_list = LessonPlan::where(['course_id' => $courseId])->selectRaw('GROUP_CONCAT(class_id) as grade')->groupBy('course_id')->first();
                $grades = array_unique(explode(",", $class_list->grade));
                if (!empty($grades)) {
                    $program_list = Program::where('status', 1)->whereIn('id', $grades)->get(['id', 'class_name']);
                }
                return $program_list;
            }

            if ($type == 'lessonplan') {
                $grade = $request->grade;
                $courseid = $request->courseid;
                $lessonplan = LessonPlan::where(['course_id' => $courseid])->whereRaw('FIND_IN_SET("' . $grade . '",class_id)')->get(['id', 'title']);
                $lesson_html = '';
                if ($lessonplan->first()) {
                    $lessonplan_sort_list = DB::table('plan_sorting')->where(['course_id' => $courseid, 'class_id' => $grade])->get(['lesson_id', 'position_order'])->toArray();
                    $postionId = 0;
                    $sortedList = [];
                    foreach ($lessonplan as $lessondata) {
                        if (!empty($lessonplan_sort_list)) {
                            $sortKey = array_search($lessondata->id, array_column($lessonplan_sort_list, 'lesson_id'));
                            $postionId = $lessonplan_sort_list[$sortKey]->position_order;
                        }
                        $sortedList[$postionId] = ['id' => $lessondata->id, 'title' => $lessondata->title, 'position' => $postionId];
                    }
                    // print_r($sortedList);
                    $orderedItems = collect($sortedList)->sortBy('position');
                    foreach ($orderedItems as $pos => $ldata) {
                        $lesson_html .= '<a class="media media-single" href="#" id="' . $ldata['id'] . '">
                                        <span class="title text-mute">' . $ldata['title'] . '</span>
                                        <span class="badge badge-pill badge-primary">' . $pos . '</span>
                                        </a>';
                    }
                }
                return $lesson_html;
            }
            exit;
        }

        $course_list = DB::table('master_course')->where('status', 1)->get();
        return view('lessonplan.lessonplan-sorting', compact('course_list'));
    }

    public function updateSortingNumber(Request $request)
    {
        $position = $request->position;
        $classId = $request->grade;
        $courseId = $request->courseid;
        $i = 1;
        if (!empty($position)) {
            foreach ($position as $k => $v) {
                DB::table('plan_sorting')->updateOrInsert(
                    [
                        'course_id' => (int)$courseId,
                        'class_id' => (int)$classId,
                        'lesson_id' => (int)$v
                    ],
                    ['position_order' => $i]
                );
                $i++;
            }
        }
    }

    public function change_demo_status(Request $request)
    {
        $lessonId = $request->lessonid;
        $status = ($request->status == 1) ? 0 : 1;
        LessonPlan::where('id', $lessonId)->update(['is_demo' => $status]);
        echo ($status == 1) ? 'Yes' : 'No';
    }
}
