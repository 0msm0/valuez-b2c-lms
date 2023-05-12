<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\{User, School, LogsModel};
use DataTables;
// use Mail;
use Psy\Readline\Hoa\Console;
use App\Models\Package;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function authuserregister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',

        ]);
        $name = $request->name;
        $email = $request->email;
        $username = $request->email;
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if ($password == $confirm_password) {
            $user_details = [
                'name' => $name,
                'email' => $email,
                'usertype' => 'admin',
                'password' => Hash::make($password),
                'view_pass' => $password
            ];
            $this->create_school_and_schooladmin($user_details);
            // User::create($user_details);
            print_r($user_details);
        }
        else {
            return back()->withErrors([
                'password' => 'Password does not match with Confirm Password.',
            ]);
        }

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            Auth::attempt(['username' => $username, 'password' => $password]);
        }

        if (Auth::check()) {
            $user = Auth::user();
            session(['usertype' => $user->usertype]);
            LogsModel::create(['userid' => $user->id, 'action' => 'login', 'logs_info' => json_encode(['info' => 'User Login', 'usertype' => $user->usertype])]);
            if ($user->usertype == 'superadmin' || $user->usertype == 'contentadmin') {
                return redirect()->intended(route('admin-dashboard'))->withSuccess('Signed in');
            } else if ($user->usertype == 'teacher') {
                return redirect()->intended(route('teacher.class.list'))->withSuccess('Signed in');
            } else if ($user->usertype == 'admin') {
                return redirect()->intended(route('school.teacher.list'))->withSuccess('Signed in');
            }
        }

        #return redirect("login")->withSuccess('Login details are not valid');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function create_school_and_schooladmin($requestdata)
    {
        /*
        $requestdata->validate([
            'title' => 'required',
            'primary_email' => 'required|email|unique:school',
            'primary_person' => 'required',
            'licence' => 'required',
            'package_start' => 'required',
            'package_end' => 'required',
            'grade_ids' => 'required',
            // 'image' => 'required',
        ]);
        */

        // if ($image = $requestdata->file('school_logo')) {
        //     $destinationPath = 'uploads/school/';
        //     $originalname = $image->hashName();
        //     $imageName = "school_" . date('Ymd') . '_' . $originalname;
        //     $image->move($destinationPath, $imageName);
        // } else {
        //     $imageName = "";
        // }

        $schoolData = [
            'school_name' => $requestdata['name'],
            'primary_person' => $requestdata['name'],
            'primary_email' => $requestdata['email'],
            'primary_mobile' => '1112223334',
            'second_email' => '',
            'second_mobile' => '',
            'mobile' => '',
            'address' => '',
            'licence' => 1,
            'school_desc' => 'Random Description',
            'school_logo' => '',
            'package_start' => now(),
            'package_end' => now()->addMonth(),
            'state_id' => 0,
            'city_id' => 0,
            'pincode' => 0,
            'is_deleted' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 1,
            'is_demo' => 1
        ];

        $school_id =  DB::table('school')->insertGetId($schoolData);
        print_r($school_id);

        $auth_user = new AuthController();
        $user_pass = $auth_user->getToken();
        $user_email = strtolower($requestdata['email']);
        $username = explode("@", $user_email);
        $userId = trim($username[0]) . date('Yims');
        $schoolAdmin = [
            'name' => $requestdata['name'],
            'email' => $user_email,
            'usertype' => 'admin',
            'password' => Hash::make($requestdata['view_pass']),
            'view_pass' => $requestdata['view_pass'],
            'school_id' => $school_id,
            'username' => $userId,
        ];
        if (!empty($requestdata['grade_ids'])) {
            $package_info = [];
            foreach ($requestdata['grade_ids'] as $grade) {
                $package_info[] = ['grade' => $grade, 'school_id' => $school_id, 'status' => 1, 'package_start' => $requestdata['package_start'], 'package_end' => $requestdata['package_end']];
            }
            Package::insert($package_info);
        }
        User::create($schoolAdmin);
        // $this->schoolAdminMail(['title' => $request->primary_person, 'userid' => $userId, 'pass' => $user_pass, 'email' => $user_email, 'school_name' => $request->title]);
        // return redirect(route('school.list'))->with(['message' => 'School added successfully!', 'status' => 'success']);
    }











    public function index()
    {
        return view('auth.login');
    }


    public function authuser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $username = $request->email;
        $password = $request->password;

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            Auth::attempt(['username' => $username, 'password' => $password]);
        }

        if (Auth::check()) {
            $user = Auth::user();
            session(['usertype' => $user->usertype]);
            LogsModel::create(['userid' => $user->id, 'action' => 'login', 'logs_info' => json_encode(['info' => 'User Login', 'usertype' => $user->usertype])]);
            if ($user->usertype == 'superadmin' || $user->usertype == 'contentadmin') {
                return redirect()->intended(route('admin-dashboard'))->withSuccess('Signed in');
            } else if ($user->usertype == 'teacher') {
                return redirect()->intended(route('teacher.class.list'))->withSuccess('Signed in');
            } else if ($user->usertype == 'admin') {
                return redirect()->intended(route('school.teacher.list'))->withSuccess('Signed in');
            }
        }

        #return redirect("login")->withSuccess('Login details are not valid');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function userlist(Request $request)
    {
        $schoolid = $request->input('school');
        $userlist = DB::table('users')->where(['school_id' => $schoolid, 'usertype' => 'teacher', 'is_deleted' => 0])->orderBy('id')->get();
        return view('users.teacher', compact('userlist', 'schoolid'));
    }

    public function addUser(Request $request)
    {
        //imp SECURITY flaw fixed at UI level
        // dd($request , Auth::user()->school->id);
        $user_schoolid = Auth::user()->school->id;
        $schoolid = $request->input('school');
        if($request->input('school') != $user_schoolid) {
            return redirect(route('teacher.list', ['school' => $user_schoolid]))->with('error','Try again');
        }
        return view('users.teacher-add', compact('schoolid'));
    }

    public function updateUser(Request $request)
    {
        $userId = $request->input('userid');
        $user = Auth::user();
        $where_cond = ['usertype' => 'teacher', 'id' => $userId];
        if (session()->get('usertype') == 'admin') {
            $where_cond['school_id'] = $user->school_id;
        }
        $user = DB::table('users')->where($where_cond)->first();
        return view('users.teacher-edit', compact('user'));
    }

    public function updateAdminUser(Request $request)
    {
        $userId = $request->userid;
        $user = Auth::user();
        $where_cond = ['usertype' => 'admin', 'id' => $userId];
        if (session()->get('usertype') == 'admin') {
            $where_cond['school_id'] = $user->school_id;
        }
        $user = DB::table('users')->where($where_cond)->first();
        return view('users.schooladmin.admin-edit', compact('user'));
    }

    public function createuser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            // 'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        $redirect = (session()->get('usertype') == 'admin') ? route('school.teacher.list') : route('teacher.list', ['school' => $data['school']]);
        if ($check == "error") {
            return redirect($redirect)->with('error', 'Maximum licences limit reached.');
        } else if ($check == 'wrong-school') {
            return redirect($redirect)->with('error', 'Wrong Account Selected. Try again.');
        } else
        {
            return redirect($redirect)->with('error', 'Some error, best to try again');
        }
    }

    public function create(array $data)
    {   
        // imp SECURITY flaw fixed
        // dd(Auth::user()->id, Auth::user()->school->id, $data['school']);
        // dd(Auth::user()->school->id != $data['school']);
        if(Auth::user()->school->id != $data['school']) {
            return 'wrong-school';
        }

        $check_school_user = School::with(['teacher' => function ($query) {
            $query->where('usertype', '=', 'teacher')->where(['is_deleted' => 0]);
        }])->where(['is_deleted' => 0, 'id' => $data['school']])->orderBy('id')->first();
        // dd($check_school_user);
        $total_teacher = $check_school_user->teacher->count();
        if ($check_school_user->licence > $total_teacher) {
            $passWord = isset($data['password']) ? $data['password'] : Str::random(10);
            $user_email = strtolower($data['email']);
            $username = explode("@", $user_email);
            $userId = trim($username[0]) . date('Yims');
            $add_user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'school_id' => $data['school'],
                'usertype' => 'teacher',
                'status' => 1,
                'username' => $userId,
                'view_pass' => $passWord,
                'password' => Hash::make($passWord)
            ];
            #print_r($add_user); die;
            #$this->UserAccountMail(['username' => $data['email'], 'userid' => $userId, 'pass' => $passWord, 'school_name' => $check_school_user->school_name]);
            return User::create($add_user);
        } else {
            return "error";
        }
    }

    public function edituser(Request $request)
    {
        $data = $request->all();
        $school = $data['school'];
        $pagetype = !empty($data['pagetype']) ? $data['pagetype'] : '';
        $updateuser = ['name' => $data['name'], 'email' => $data['email']];
        $validate = ['name' => 'required', 'email' => 'required|email|unique:users,email,' . $data['id']];
        if (!empty($data['password'])) {
            $validate['password'] = ['required', Password::min(6)];
            $updateuser['password'] = Hash::make($data['password']);
            $updateuser['view_pass'] = $data['password'];
        }
        $request->validate($validate);
        User::where('id', $data['id'])->update($updateuser);
        if (!empty($data['password'])) {
            $details = [
                'view' => 'emails.reset_password',
                'subject' => $data['name'] . ' Your Account Password Reset by admin - Valuez',
                'title' => $data['name'],
                'email' => $data['email'],
                'pass' => $data['password']
            ];
            Mail::to($data['email'])->send(new \App\Mail\TestMail($details));
        }
        $redirect = (session()->get('usertype') == 'admin') ? route('school.teacher.list') : route('teacher.list', ['school' => $school]);

        $redirect_url = ($pagetype == 'schooladmin') ? route('school.admin') : $redirect;
        return redirect($redirect_url)->with('success', 'User Updated successfully');
    }

    public function resetPassword(Request $request)
    {
        $passWord = $this->getToken();
        $resetPass = User::where('id', $request->userid)->update(['view_pass' => $passWord, 'password' => Hash::make($passWord)]);
        if ($resetPass) {
            $user_email = User::where('id', $request->userid)->first();
            $details = [
                'view' => 'emails.reset_password',
                'subject' => 'User Account Password Reset - Valuez',
                'title' => $user_email->name,
                'email' => $user_email->email,
                'pass' => $passWord
            ];
            Mail::to($user_email->email)->send(new \App\Mail\TestMail($details));
        }
    }

    public function destroy(Request $request)
    {
        $userId = $request->input('userid');
        $userPass = $request->input('userpass');
        if (Auth::check()) {
            $user = Auth::user();
            if (Hash::check($userPass, $user->password)) {
                DB::table('users')->where('id', $userId)->update(['is_deleted' => 1]);
                return response()->json(['success' => true, 'msg' => 'User deleted successfully!']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Entered Password Incorrect.']);
            }
        } else {
            return response()->json(['success' => false, 'msg' => 'Somenthing Went Wrong!']);
        }
    }

    public function AdminDash()
    {
        if (Auth::check()) {
            $school = $teacher = $program = $lessonplan = 0;

            $school = DB::table('school')->where('status', 1)->get()->count();
            $teacher = DB::table('users')->where('usertype', 'teacher')->get()->count();
            $course = DB::table('master_course')->where('status', 1)->get()->count();
            $program = DB::table('master_class')->where('status', 1)->get()->count();
            $lessonplan = DB::table('lesson_plan')->where('status', 1)->get()->count();

            return view('dashboard-admin', compact('school', 'teacher', 'program', 'lessonplan', 'course'));
        } else {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $schoolid = $user->school_id;
            if (session()->get('usertype') == 'admin') {
                $school = School::with(['teacher' => function ($query) {
                    $query->where('usertype', '=', 'teacher');
                }])->where('id', $schoolid)->orderBy('id')->first();

                // dd($school);

                $package_start = new \DateTime($school->package_start);
                $package_end = new \DateTime($school->package_end);
                $interval = $package_start->diff($package_end);
                $time_left = $interval->format('%a');

                // dd($package_start);
                return view('dashboard', compact('school', 'schoolid', 'time_left', 'user'));
            } else {
                return view('dashboard-teacher');
            }
        } else {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
    }

    public function teacherList()
    {
        $user = Auth::user();
        $schoolid = $user->school_id;
        $userlist = DB::table('users')->where(['school_id' => $user->school_id, 'usertype' => 'teacher', 'is_deleted' => 0])->orderBy('id')->get();
        return view('users.teacher', compact('userlist', 'schoolid'));
    }

    public function SchoolAdmin(Request $request)
    {
        $schoolid = $request->school;
        $userlist = User::where(['school_id' => $schoolid, 'usertype' => 'admin', 'users.is_deleted' => 0])->orderBy('id')->get();
        return view('users.schooladmin.admin', compact('userlist','schoolid'));
    }

    public function signOut(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            LogsModel::create(['userid' => $userId, 'action' => 'logout', 'logs_info' => json_encode(['info' => 'User logout', 'usertype' => $user->usertype])]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    // Generate token
    public function getToken($length = 8)
    {
        return Str::random($length);
    }

    public function UserAccountMail($data)
    {
        $details = [
            'view' => 'emails.account',
            'subject' => 'User Account creation Mail from Valuez',
            'title' => $data['username'],
            'userid' => $data['userid'],
            'pass' => $data['pass'],
            'school_name' => $data['school_name'],
        ];
        #Mail::to($data['username'])->send(new \App\Mail\TestMail($details));
    }
}
