<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.course');
    }

    public function addcourse()
    {
        return view('course.course-add');
    }

    public function editcourse()
    {
        return view('course.course-edit');
    }

    
}
