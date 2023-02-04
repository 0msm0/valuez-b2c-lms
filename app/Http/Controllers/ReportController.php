<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Reports, Program, Course};
use Illuminate\Support\Facades\Auth;
use DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $school = $request->school;
        if ($request->ajax()) {
            $data = Reports::query()->with(['lessonplan', 'userinfo'])->where(['school' => $request->school]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('course', function ($row) {
                    $course = Course::find($row->lessonplan->course_id);
                    return $course->course_name;
                })
                ->editColumn('grade', function ($row) {
                    $program = Program::whereIn('id', explode(',', $row->lessonplan->class_id))->get(['class_name'])->toArray();
                    $class_name = array_column($program, 'class_name');
                    return $class_name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->make(true);
        }

        return view('reports.metrics', compact('school'));
    }

    public function viewTeacherSummary(Request $request)
    {
        $user = Auth::user();
        if (($user) && $user->usertype == "teacher") {
            if ($request->ajax()) {
                $data = Reports::query()->with(['lessonplan', 'userinfo'])->where(['school' => $user->school_id, 'userid' => $user->id]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('course', function ($row) {
                        $course = Course::find($row->lessonplan->course_id);
                        return $course->course_name;
                    })
                    ->editColumn('grade', function ($row) {
                        $program = Program::whereIn('id', explode(',', $row->lessonplan->class_id))->get(['class_name'])->toArray();
                        $class_name = array_column($program, 'class_name');
                        return $class_name;
                    })
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at;
                    })
                    ->make(true);
            }
        }
        return view('reports.lessonhistory');
    }
}
