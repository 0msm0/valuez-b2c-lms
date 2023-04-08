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
                    $program = Program::where('id', $row->classId)->get(['class_name'])->toArray();
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
                        $program = Program::find($row->classId);                        
                        return $program->class_name;
                    })
                    ->editColumn('created_at', function ($row) {
                        return date('d-m-Y h:i A', strtotime($row->created_at));
                    })
                    ->make(true);
            }
        }
        return view('reports.lessonhistory');
    }

    public function viewTeacherGradeSummary(Request $request)
    {
        $user = Auth::user();
        if (($user) && $user->usertype == "teacher") {
            if ($request->ajax()) {
                $data = Reports::where(['school' => $user->school_id, 'userid' => $user->id, 'lesson_plan.course_id' => $request->courseId, 'classId' => $request->classId])->join('lesson_plan', 'lesson_plan.id', '=', 'reports.lesson_plan')->selectRaw('lesson_plan.title,DATE_FORMAT(reports.created_at, "%d-%m-%Y %h:%i %p") as created_report')->get()->toArray();
                return response()->json($data);
            }
        }
    }
}
