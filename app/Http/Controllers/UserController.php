<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\{User};
use DataTables;

class UserController extends Controller
{
    public  function index(Request $request)
    {
        if ($request->ajax()) {
            $adminuserlist = User::query()->where(['users.is_deleted' => 0])->whereIn('usertype', ['contentadmin']);
            return Datatables::of($adminuserlist)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('Y-m-d', strtotime($row->created_at));
                })
                ->editColumn('status', function ($row) {
                    $span_btn = '<span class="badge bg-' . ($row->status == 1 ? 'success' : 'danger') . '">' . ($row->status == 1 ? 'Active' : 'Inactive') . '</span>';
                    return $span_btn;
                })
                ->addColumn('action', function ($row) {
                    $remove = '';
                    if ($row->usertype == 'contentadmin') {
                        $remove = ' <a href="javascript:void(0)" class="edit btn btn-outline btn-danger btn-sm mb-5">Delete</a>';
                    }
                    $edit = '<a href="' . route('users.admin.edit', ['userid' => $row->id]) . '" class="btn btn-sm btn-outline btn-info mb-5">Edit</a>';

                    return $edit . $remove;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('users.masteruser.manage-user');
    }

    public function AddAdminUser(Request $request)
    {
        return view('users.masteruser.master-user-add');
    }

    public function editAdminUser(Request $request)
    {
        $userId = $request->input('userid');

        $adminuser = User::where(['id' => $userId])->first();
        return view('users.masteruser.master-user-edit', compact('adminuser'));
    }

    public function AddUpdateAdminUser(Request $request)
    {
        $data = $request->all();

        $updateuser = ['name' => $data['name'], 'email' => $data['email'], 'usertype' => $data['usertype'], 'status' => $data['status'], 'status' => $data['status']];
        $validate = ['name' => 'required', 'email' => 'required|email|unique:users,email,' . $data['id']];
        if (!empty($data['password'])) {
            $validate['password'] = ['required', Password::min(6)];
            $updateuser['password'] = Hash::make($data['password']);
            $updateuser['view_pass'] = $data['password'];
        }

        $request->validate($validate);
        // dd($updateuser);
        if ($data['id'] > 0) {
            User::where('id', $data['id'])->update($updateuser);
        } else {
            $updateuser['created_at'] = date('Y-m-d H:i:s');
            User::insert($updateuser);
        }

        return redirect(route('users.admin.list'))->with('success', 'User Updated successfully');
    }
}
