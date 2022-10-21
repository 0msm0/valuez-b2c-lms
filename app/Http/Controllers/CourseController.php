<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $course = DB::table('master_course')->orderBy('id')->get();
        return view('course.course',compact('course'));
    }

    public function addcourse()
    {
        return view('course.course-add');
    }

    public function editcourse(Request $request)
    {
        $courseId = $request->input('course');
        $course = DB::table('master_course')->where('id',$courseId)->first();
        return view('course.course-edit',compact('course'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/course/';
            $imageName = "course_".date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        }

        $courseData = ['course_name' => $request->title, 'status' => $request->status, 'course_image' => $imageName];
        DB::table('master_course')->insert($courseData);
        return redirect(route('course.list'))->with(['message' => 'Course added successfully!', 'status' => 'success']);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/course/';
            $imageName = "course_".date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        }else{
            $imageName = $request->old_image;
        }
        $courseData = ['course_name' => $request->title, 'status' => $request->status, 'course_image' => $imageName];
        DB::table('master_course')->where('id', $request->id)->update($courseData);
        return redirect(route('course.list'))->with(['message' => 'Course updated successfully!', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $courseId = $request->input('course');
        DB::table('master_course')->where('id', $courseId)->delete();
        return redirect(route('course.list'))->with('success','Course deleted successfully');
    }
}
