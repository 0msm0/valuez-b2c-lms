<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function index()
    {
        $class_list = DB::table('master_class')->orderBy('id')->get();
        return view('program.program',compact('class_list'));
    }

    public function addprogram()
    {
        return view('program.program-add');
    }

    public function editprogram(Request $request)
    {
        $classId = $request->input('program');
        $class = DB::table('master_class')->where('id',$classId)->first();
        return view('program.program-edit',compact('class'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/program/';
            $originalname = $image->getClientOriginalName();
            $imageName = "class_".$originalname.date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        }

        $classData = ['class_name' => $request->title, 'status' => $request->status, 'class_image' => $imageName];
        DB::table('master_class')->insert($classData);
        return redirect(route('program.list'))->with(['message' => 'Program added successfully!', 'status' => 'success']);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/program/';
            $originalname = $image->getClientOriginalName();
            $imageName = "class_".$originalname.date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            $image_path = $destinationPath.$request->old_image;
            @unlink($image_path);
        }else{
            $imageName = $request->old_image;
        }
        $classData = ['class_name' => $request->title, 'status' => $request->status, 'class_image' => $imageName];
        DB::table('master_class')->where('id', $request->id)->update($classData);
        return redirect(route('program.list'))->with(['message' => 'Program updated successfully!', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $classId = $request->input('program');
        DB::table('master_class')->where('id', $classId)->delete();
        return redirect(route('program.list'))->with('success','Program deleted successfully');
    }
}
