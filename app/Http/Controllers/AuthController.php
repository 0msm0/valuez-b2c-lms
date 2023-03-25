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
use Mail;


class AuthController extends Controller
{
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
        $schoolid = $request->input('school');
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
        } else {
            return redirect($redirect)->withSuccess('User added successfully!');
        }
    }

    public function create(array $data)
    {
        $check_school_user = School::with(['teacher' => function ($query) {
            $query->where('usertype', '=', 'teacher')->where(['is_deleted' => 0]);
        }])->where(['is_deleted' => 0])->orderBy('id')->first();

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
            $this->UserAccountMail(['username' => $data['email'], 'userid' => $userId, 'pass' => $passWord]);
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

                $package_start = new \DateTime(date("Y-m-d h:i:s"));
                $package_end = new \DateTime($school->package_end);
                $interval = $package_start->diff($package_end);
                $time_left = $interval->format('%a');

                return view('dashboard', compact('school', 'time_left'));
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

        if ($request->ajax()) {
            $adminuserlist = User::query()->with('school')->where(['usertype' => 'admin', 'users.is_deleted' => 0]);
            return Datatables::of($adminuserlist)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('Y-m-d', strtotime($row->created_at));
                })
                ->editColumn('school_id', function ($row) {
                    return $row->school->school_name;
                })
                ->addColumn('action', function ($row) {
                    $edit = '<a href="' . route('school.admin.edit', ['userid' => $row->id]) . '" class="waves-effect waves-light btn btn-sm btn-outline btn-info mb-5">Edit</a>';
                    #$remove = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $edit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.schooladmin.admin');
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
            'pass' => $data['pass']
        ];
        Mail::to($data['username'])->send(new \App\Mail\TestMail($details));
    }
}
