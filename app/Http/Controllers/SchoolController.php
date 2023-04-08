<?php

namespace App\Http\Controllers;

use App\Models\{User, School, CitiesModel, StateModel, LogsModel, Program, Package};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Mail;


class SchoolController extends Controller
{
    public function index()
    {
        $school = School::with(['teacher' => function ($query) {
            $query->where('usertype', '=', 'teacher')->where(['is_deleted' => 0]);
        }])->where(['is_deleted' => 0])->orderBy('id')->get();

        return view('school.school-list', compact('school'));
    }

    public function addschool()
    {
        $states = StateModel::where("flag", 1)->get(["name", "id"]);
        $grades = Program::where("status", 1)->get(["class_name", "id"]);
        return view('school.school-add', compact('states', 'grades'));
    }

    public function editschool(Request $request)
    {
        $schoolId = $request->input('school');
        $school = DB::table('school')->where('id', $schoolId)->first();
        $states = StateModel::where("flag", 1)->get(["name", "id"]);
        $grades = Program::where("status", 1)->get(["class_name", "id"]);
        $package = Package::where('school_id', $schoolId)->get(['grade'])->toArray();
        $grade_ids = ($package) ? array_column($package, 'grade') : [];
        return view('school.school-edit', compact('school', 'states', 'grades', 'grade_ids'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'primary_email' => 'required|email|unique:school',
            'primary_person' => 'required',
            'licence' => 'required',
            'package_start' => 'required',
            'package_end' => 'required',
            'grade_ids' => 'required',
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
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
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
        if (!empty($request->grade_ids)) {
            $package_info = [];
            foreach ($request->grade_ids as $grade) {
                $package_info[] = ['grade' => $grade, 'school_id' => $school_id, 'status' => 1, 'package_start' => $request->package_start, 'package_end' => $request->package_end];
            }
            Package::insert($package_info);
        }
        User::create($schoolAdmin);
        $this->schoolAdminMail(['title' => $request->primary_person, 'userid' => $userId, 'pass' => $user_pass, 'email' => $user_email, 'school_name' => $request->title]);
        return redirect(route('school.list'))->with(['message' => 'School added successfully!', 'status' => 'success']);
    }

    public function schoolAdminMail($data)
    {
        $details = [
            'view' => 'emails.account',
            'subject' => 'School Admin Account creation Mail from Valuez',
            'title' => $data['title'],
            'username' => $data['email'],
            'pass' => $data['pass'],
            'school_name' => $data['school_name'],
        ];
        Mail::to($data['email'])->send(new \App\Mail\TestMail($details));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'primary_person' => 'required',
            'primary_email' => 'required',
            'licence' => 'required',
            'package_start' => 'required',
            'package_end' => 'required',
            'grade_ids' => 'required',
            // 'image' => 'required',
        ]);

        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/school/';
            $originalname = $image->hashName();
            $imageName = "plan_" . date('Ymd') . '_' . $originalname;
            $image->move($destinationPath, $imageName);
            $image_path = $destinationPath . $request->old_image;
            @unlink($image_path);
        } else {
            $imageName = $request->old_image;
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
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
            'is_deleted' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $request->status,
        ];

        $admin_user_data = [
            'name' => $request->primary_person,
            'email' => $request->primary_email,
        ];

        if (!empty($request->primary_password)) {
            $admin_user_data['view_pass'] = $request->primary_password;
            $admin_user_data['password'] = Hash::make($request->primary_password);
            User::where(['school_id' => $request->id, 'usertype' => 'admin'])->update($admin_user_data);
        }

        if (!empty($request->grade_ids)) {
            $package_info = [];
            $package = Package::where('school_id', $request->id)->get(['grade'])->toArray();
            $grade_ids = ($package) ? array_column($package, 'grade') : [];
            $remove_grade = array_diff($grade_ids, $request->grade_ids);
            if (!empty($remove_grade)) {
                Package::whereIn('grade', $remove_grade)->where(['school_id' => $request->id])->delete();
            }

            foreach ($request->grade_ids as $grade) {
                $package_info = ['status' => 1, 'package_start' => $request->package_start, 'package_end' => $request->package_end];
                Package::updateOrCreate(['grade' => $grade, 'school_id' => $request->id], $package_info);
            }
        }

        DB::table('school')->where('id', $request->id)->update($schoolData);
        return redirect(route('school.list'))->with(['message' => 'School Updated successfully!', 'status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $schoolId = $request->input('school');
        $userPass = $request->input('userpass');
        if (Auth::check()) {
            $user = Auth::user();
            if (Hash::check($userPass, $user->password)) {
                DB::table('school')->where('id', $schoolId)->update(['is_deleted' => 1]);
                DB::table('users')->where('school_id', $schoolId)->update(['is_deleted' => 1]);
                return response()->json(['success' => true, 'msg' => 'School deleted successfully!']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Entered Password Incorrect.']);
            }
        } else {
            return response()->json(['success' => false, 'msg' => 'Somenthing Went Wrong!']);
        }
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

    public function change_school_demo_status(Request $request)
    {
        $schoolId = $request->school;
        $status = ($request->status == 1) ? 0 : 1;
        School::where('id', $schoolId)->update(['is_demo' => $status]);
        echo ($status == 1) ? 'Yes' : 'No';
    }
    public function CityList(Request $request)
    {
        $data['cities'] = CitiesModel::where("state_id", $request->state_id)->get(["city", "id"]);
        return response()->json($data);
    }

    public function viewLogs(Request $request)
    {
        $user = Auth::user();
        $userId = $request->userid;
        if (($user) && $user->usertype == "superadmin") {
            $whercond = ['userid' => $userId];
        } else {
            $school_id = $user->school_id;
            $whercond = ['userid' => $userId, 'school_id' => $school_id];
        }

        if ($request->ajax()) {
            $userLogs = LogsModel::query()->join('users as u', 'u.id', '=', 'userid')->where($whercond)->get(['logs.id', 'logs_info', 'action', 'logs.created_at']);
            return Datatables::of($userLogs)
                ->addIndexColumn()
                ->editColumn('logs_info', function ($row) {
                    return json_decode($row->logs_info)->info . " at <strong>" . date('d-m-Y', strtotime($row->created_at)) . "</strong>";
                })
                ->rawColumns(['logs_info'])
                ->make(true);
        }
        return view('users.userlogs', compact('userId'));
    }

    public function previewSchool(Request $request)
    {
        $school_id = $request->school;
        if ($school_id > 0) {
            $school_data = School::find($school_id);
            $package = Package::with('grade')->where('school_id', $school_id)->get()->toArray();

            $city_state = CitiesModel::with('state')->where(["state_id" => $school_data->state_id, "id" => $school_data->city_id])->first();
            $grade_name = [];
            if (!empty($package)) {
                foreach ($package as $grade) {
                    $grade_name[] = @$grade['grade']['class_name'];
                }
            }
            $grades = implode(",", $grade_name);
            return view('school.preview_school', compact('school_data', 'city_state', 'grades'));
        }
    }
}
