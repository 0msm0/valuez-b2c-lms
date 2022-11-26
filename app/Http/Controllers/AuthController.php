<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\{User, School};


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

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            session(['usertype' => $user->usertype]);
            if ($user->usertype == 'superadmin') {
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
        $userlist = DB::table('users')->where(['school_id' => $schoolid, 'usertype' => 'teacher'])->orderBy('id')->get();
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
        $user = DB::table('users')->where(['usertype' => 'teacher', 'id' => $userId])->first();
        return view('users.teacher-edit', compact('user'));
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
        return redirect($redirect)->withSuccess('User added successfully!');
    }

    public function create(array $data)
    {
        $passWord = isset($data['password']) ? $data['password'] : Str::random(10);
        $add_user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'school_id' => $data['school'],
            'usertype' => 'teacher',
            'status' => 1,
            'password' => Hash::make($passWord)
        ];
        #print_r($add_user); die;
        return User::create($add_user);
    }

    public function edituser(Request $request)
    {
        $data = $request->all();
        $school = $data['school'];
        $updateuser = ['name' => $data['name'], 'email' => $data['email']];
        $validate = ['name' => 'required', 'email' => 'required|email|unique:users,email,' . $data['id']];
        if (!empty($data['password'])) {
            $validate['password'] = ['required', Password::min(6)];
            $updateuser['password'] = Hash::make($data['password']);
        }
        $request->validate($validate);
        User::where('id', $data['id'])->update($updateuser);
        $redirect = (session()->get('usertype') == 'admin') ? route('school.teacher.list') : route('teacher.list', ['school' => $school]);
        return redirect($redirect)->with('success', 'User Updated successfully');
    }

    public function destroy(Request $request)
    {
        $userId = $request->input('userid');
        DB::table('users')->where('id', $userId)->update(['is_deleted' => 1]);
        return redirect(route('teacher.list'))->with('success', 'User deleted successfully');
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
        $userlist = DB::table('users')->where(['school_id' => $user->school_id, 'usertype' => 'teacher'])->orderBy('id')->get();
        return view('users.teacher', compact('userlist', 'schoolid'));
    }

    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
