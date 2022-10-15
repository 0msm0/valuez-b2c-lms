<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return view('program.program');
    }

    public function addprogram()
    {
        return view('program.program-add');
    }

    public function editprogram()
    {
        return view('program.program-edit');
    }
}
