<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;


class SchoolController extends Controller
{
    public function index()
    {
        $school = School::with(['teacher' => function ($query) {
            $query->where('usertype', '=', 'teacher');
        }])->orderBy('id')->get();

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
            'primary_email' => 'required|email|unique:school',
            // 'image' => 'required',
        ]);


        if ($image = $request->file('school_logo')) {
            $destinationPath = 'uploads/school/';
            $originalname = $image->hashName();
            $imageName = "school_" . date('Ymd') . '_' . $originalname;
            $image->move($destinationPath, $imageName);
        } else {
            $imageName = "";
        }

        $schoolData = [
            'school_name' => $request->title,
            'primary_person' => $request->primary_person,
            'primary_email' => $request->primary_email,
            'primary_mobile' => $request->primary_mobile,
            'second_email' => $request->secondary_email,
            'second_mobile' => $request->secondary_mobile,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'licence' => $request->licence,
            'school_desc' => $request->school_desc,
            'school_logo' => $imageName,
            'package_start' => $request->package_start,
            'package_end' => $request->package_end,
            'is_deleted' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => $request->status,
        ];

        $school_id =  DB::table('school')->insertGetId($schoolData);
        $auth_user = new AuthController();
        $user_pass = $auth_user->getToken();
        $user_email = strtolower($request->primary_email);
        $username = explode("@", $user_email);
        $userId = trim($username[0]) . date('Yims');
        $schoolAdmin = [
            'name' => $request->primary_person,
            'email' => $user_email,
            'usertype' => 'admin',
            'password' => Hash::make($user_pass),
            'view_pass' => $user_pass,
            'school_id' => $school_id,
            'username' => $userId,
        ];
        User::create($schoolAdmin);
        $this->schoolAdminMail(['username' => $request->primary_person, 'userid' => $userId, 'pass' => $user_pass]);
        return redirect(route('school.list'))->with(['message' => 'School added successfully!', 'status' => 'success']);
    }

    public function schoolAdminMail($data)
    {
        $details = [
            'view' => 'emails.account',
            'subject' => 'User Account creation Mail from Valuez',
            'title' => $data['username'],
            'userid' => $data['userid'],
            'pass' => $data['pass']
        ];
        Mail::to('test@lms.democlicks.com')->send(new \App\Mail\TestMail($details));
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
        #DB::table('school')->where('id', $schoolId)->update(['is_deleted' => 1]);
        return redirect(route('school.list'))->with('success', 'School deleted successfully');
    }

    public function change_status(Request $request)
    {
        $schoolId = $request->school;
        $status = ($request->status == 1) ? 0 : 1;
        DB::table('school')->where('id', $schoolId)->update(['status' => $status]);
        echo ($status == 1) ? 'Active' : 'Inactive';
    }

    public function change_user_status(Request $request)
    {
        $userId = $request->userid;
        $status = ($request->status == 1) ? 0 : 1;
        DB::table('users')->where('id', $userId)->update(['status' => $status]);
        echo ($status == 1) ? 'Active' : 'Inactive';
    }
}
