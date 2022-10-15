<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonPlanController extends Controller
{
    public function index()
    {
        return view('lessonplan.lessonplan');
    }

    public function addlessonplan()
    {
        return view('lessonplan.lessonplan-add');
    }

    public function editlessonplan()
    {
        return view('lessonplan.lessonplan-edit');
    }
}
