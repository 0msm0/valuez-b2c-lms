<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationModel;
use DataTables;

class Notification extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NotificationModel::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('Y-m-d', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('notification.notify');
    }

    public function addnewNotification(Request $request)
    {
        return view('notification.notify-add');
    }

    public function addUpdateNotify(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description_txt' => 'required',
        ]);

        $notifyData = ['title' => $request->title, 'status' => $request->status, 'description' => $request->description_txt];
        NotificationModel::create($notifyData);
        return redirect(route('notify.list'))->with(['message' => 'What\'s New added successfully!', 'status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $notifyId = $request->notifyId;
        NotificationModel::where('id', $notifyId)->delete();
        return redirect(route('notify.list'))->with('success', 'What\'s New deleted successfully');
    }


    public function viewNotify(Request $request)
    {
        if ($request->ajax()) {
            $data = NotificationModel::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('description', function ($row) {
                    $created_at = date('Y-m-d', strtotime($row->created_at));
                    $title = $row->title;
                    $text_desc = $row->description;
                    $view_notify = '<div class="media align-items-center">
						  <div class="media-body">
							<p class="fs-16"><a class="hover-primary" href="#">' . $title . '</a></p>
							  <span class="text-fade fs-12">' . $created_at . '</span>
						  </div>
						</div><div class="media pt-0"><p class="text-mute">' . $text_desc . '</p></div>';
                    return $view_notify;
                })
                ->rawColumns(['description'])
                ->make(true);
        }
        return view('notification.view_notify');
    }
}
