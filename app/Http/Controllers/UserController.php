<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User};
use DataTables;

class UserController extends Controller
{
    public  function index(Request $request)
    {
        if ($request->ajax()) {
            $adminuserlist = User::query()->where(['usertype' => 'superadmin', 'users.is_deleted' => 0]);
            return Datatables::of($adminuserlist)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('Y-m-d', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    $edit = '<a href="' . route('school.admin.edit', ['userid' => $row->id]) . '" class="btn btn-sm btn-outline btn-info mb-5">Edit</a>';
                    $remove = ' <a href="javascript:void(0)" class="edit btn btn-outline btn-danger btn-sm mb-5">Delete</a>';
                    return $edit . $remove;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.manage-user');
    }
}
