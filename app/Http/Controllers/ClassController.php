<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClassController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = ClassModel::getRecord($request);
        $data['header_title'] = 'Class List';
        return view('admin.class.list', $data);
    }
    public function add()
    {

        $data['header_title'] = 'Add Class';
        return view('admin.class.add', $data);
    }
    public function insert(Request $request)
    {
        $save = new ClassModel();
        $save->name = $request->name;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/class/list')->with('success', 'Class successfully created');
    }
    public function edit($id)
    {
        $data['getRecord'] = ClassModel::where('id', $id)->first();
        $data['header_title'] = 'Edit Class';
        return view('admin.class.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $save = ClassModel::find($id);
        $save->name = $request->name;
        $save->status = $request->status;
        $save->save();

        return redirect('admin/class/list')->with('success', 'Class successfully updated');
    }
    public function delete($id)
    {
        $class = ClassModel::find($id);
        $class->is_delete = 1;
        $class->save();
        return redirect()->back()->with('success', 'Class successfully deleted');
    }
}
