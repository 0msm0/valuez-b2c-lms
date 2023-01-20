<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Reports, School};
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
                ->editColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->make(true);
        }

        return view('reports.metrics', compact('school'));
    }
}
