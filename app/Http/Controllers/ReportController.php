<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Reports, School};

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $school = School::with(['teacher' => function ($query) {
            $query->where('usertype', '=', 'teacher')->where(['is_deleted' => 0]);
        }])->where(['is_deleted' => 0, 'id' => $request->school])->orderBy('id')->first();

        return view('reports.metrics',compact('school'));
    }
}
