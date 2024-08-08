<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = SubjectModel::getRecord($request);
        $data['header_title'] = 'Subject List';
        return view('admin.subject.list', $data);
    }
    public function add()
    {

        $data['header_title'] = 'Add Subject';
        return view('admin.subject.add', $data);
    }
    public function insert(Request $request)
    {
        $save = new SubjectModel();
        $save->name = trim($request->name);
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/subject/list')->with('success', 'Subject successfully created');
    }
    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::where('id', $id)->first();
        $data['header_title'] = 'Edit Subject';
        return view('admin.subject.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $save = SubjectModel::find($id);
        $save->name = trim($request->name);
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->save();

        return redirect('admin/subject/list')->with('success', 'Subject successfully updated');
    }
    public function delete($id)
    {
        $save = SubjectModel::find($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success', 'Subject successfully deleted');
    }
}
