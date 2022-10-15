<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        return view('school.school-list');
    }

    public function addschool()
    {
        return view('school.school-add');
    }

    public function editschool()
    {
        return view('school.school-edit');
    }
}
