<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonPlanController extends Controller
{
    public function index()
    {
        $lessonplan = DB::table('lesson_plan')
            ->join('master_class', 'master_class.id', '=', 'lesson_plan.class_id')
            ->join('master_course', 'master_course.id', '=', 'lesson_plan.course_id')
            ->select('lesson_plan.*', 'master_class.class_name', 'master_course.course_name')
            ->orderBy('id')->get();
        return view('lessonplan.lessonplan', compact('lessonplan'));
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
            $imageName = "plan_" . date('Ymd').'_'. $originalname;
            $image->move($destinationPath, $imageName);
        }

        $courseData = [
            'title' => $request->title,
            'video_url' => $request->video_url,
            'lesson_no' => $request->lesson_no,
            'lesson_desc' => $request->lesson_desc,
            'class_id' => $request->class_id,
            'course_id' => $request->course_id,
            'status' => $request->status,
            'lesson_image' => $imageName
        ];
        // print_r($courseData); die;
        DB::table('lesson_plan')->insert($courseData);
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
            $imageName = "plan_" . date('Ymd').'_'. $originalname;
            $image->move($destinationPath, $imageName);
            $image_path = $destinationPath . $request->old_image;
            @unlink($image_path);
        } else {
            $imageName = $request->old_image;
        }

        $courseData = [
            'title' => $request->title,
            'video_url' => $request->video_url,
            'lesson_no' => $request->lesson_no,
            'lesson_desc' => $request->lesson_desc,
            'class_id' => $request->class_id,
            'course_id' => $request->course_id,
            'status' => $request->status,
            'lesson_image' => $imageName
        ];
        // print_r($courseData); die;
        DB::table('lesson_plan')->where('id', $request->id)->update($courseData);
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
        DB::table('lesson_plan')->where('id', $lessonId)->delete();
        return redirect(route('lesson.plan.list'))->with('success', 'Lesson Plan deleted successfully');
    }
}
