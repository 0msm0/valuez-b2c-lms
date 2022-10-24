<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function index()
    {
        $school = DB::table('school')->orderBy('id')->get();
        return view('school.school-list', compact('school'));
    }

    public function addschool()
    {
        return view('school.school-add');
    }

    public function editschool(Request $request)
    {
        $schoolId = $request->input('school');
        $school = DB::table('school')->where('id', $schoolId)->first();
        return view('school.school-edit', compact('school'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'image' => 'required',
        ]);


        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/school/';
            $originalname = $image->hashName();
            $imageName = "school_" . date('Ymd') . '_' . $originalname;
            // $image->move($destinationPath, $imageName);
        }

        $schoolData = [
            'school_name' => $request->title,
            'primary_person' => $request->primary_person,
            'primary_email' => $request->primary_email,
            'primary_mobile' => $request->primary_mobile,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'licence' => $request->licence,
            'is_deleted' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => $request->status,
        ];
        DB::table('school')->insert($schoolData);
        return redirect(route('school.list'))->with(['message' => 'School added successfully!', 'status' => 'success']);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'image' => 'required',
        ]);     

        $schoolData = [
            'school_name' => $request->title,
            'primary_person' => $request->primary_person,
            'primary_email' => $request->primary_email,
            'primary_mobile' => $request->primary_mobile,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'licence' => $request->licence,
            'is_deleted' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $request->status,
        ];
        
        DB::table('school')->where('id', $request->id)->update($schoolData);
        return redirect(route('school.list'))->with(['message' => 'School Updated successfully!', 'status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $schoolId = $request->input('schoolid');
        DB::table('school')->where('id', $schoolId)->update(['is_deleted' => 1]);
        return redirect(route('school.list'))->with('success', 'School deleted successfully');
    }
}
