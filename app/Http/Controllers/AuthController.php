<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;


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
            return redirect()->intended('dashboard')->withSuccess('Signed in');
        }

        #return redirect("login")->withSuccess('Login details are not valid');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function userlist(Request $request)
    {
        $schoolId = $request->input('school');
        $userlist = DB::table('users')->where(['usertype' => 'teacher'])->orderBy('id')->get();
        return view('users.teacher', compact('userlist'));
    }

    public function addUser()
    {
        return view('users.teacher-add');
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

        return redirect(route('teacher.list'))->withSuccess('User added successfully!');
    }

    public function create(array $data)
    {
        $passWord = isset($data['password']) ? $data['password'] : Str::random(10);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($passWord)
        ]);
    }

    public function edituser(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$data['id'],
            // 'password' => 'min:6',
        ]);
        
        User::where('id', $data['id'])->update([
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        return redirect(route('teacher.list'))->with('success', 'User Updated successfully');
    }

    public function destroy(Request $request)
    {
        $userId = $request->input('userid');
        DB::table('users')->where('id', $userId)->delete();
        return redirect(route('teacher.list'))->with('success', 'User deleted successfully');
    }

    public function dashboard()
    {
        #if (Auth::check()) {
        return view('dashboard');
        #}

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
