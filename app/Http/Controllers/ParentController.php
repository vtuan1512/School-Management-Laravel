<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecords'] = User::getParent($request);
        $data['header_title'] = 'Parent List';
        return view('admin.parent.list', $data);
    }
    public function add()
    {
        $data['header_title'] = 'Add Parent';
        return view('admin.parent.add', $data);
    }
    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'address' => 'max:255',
            'mobile_number' => 'max:15|min:8',
            'occupation' => 'max:255',
        ]);

        $parent = new User();
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);
        $parent->occupation = trim($request->occupation);
        $parent->address = trim($request->address);
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('uploads/parent/', $fileName);
            $parent->profile_pic = $fileName;
        }
        $parent->mobile_number = trim($request->mobile_number);
        $parent->status = trim($request->status);
        $parent->email = trim($request->email);
        $parent->password = Hash::make($request->password);
        $parent->user_type = 4;
        $parent->save();
        return redirect('admin/parent/list')->with('success', 'Parent added successfully');
    }
    public function edit($id)
    {
        $data['getRecord'] = User::find($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Parent';
            return view('admin.parent.edit', $data);
        } else {
            abort(404);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'max:255',
            'mobile_number' => 'max:15|min:8',
            'occupation' => 'max:255',
        ]);
        $parent = User::find($id);
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);
        $parent->occupation = trim($request->occupation);
        $parent->address = trim($request->address);
        if (!empty($request->file('profile_pic'))) {
            if (!empty($parent->getProfile_Parent())) {
                unlink('uploads/parent/' . $parent->profile_pic);  // delete old file before uploading new one
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('uploads/parent/', $fileName);
            $parent->profile_pic = $fileName;
        }
        $parent->mobile_number = trim($request->mobile_number);
        $parent->status = trim($request->status);
        $parent->email = trim($request->email);

        if (!empty($request->password)) {
            $parent->password = Hash::make($request->password);
        }
        $parent->save();
        return redirect('admin/parent/list')->with('success', 'Parent updated successfully');
    }
    public function delete($id)
    {
        $parent = User::find($id);
        if (!empty($parent)) {
            $parent->is_delete = 1;
            $parent->save();
            return redirect()->back()->with('success', 'Parent deleted successfully');
        } else {
            abort(404);
        }
    }
    public function myStudent($id, Request $request)
    {
        $data['getParent'] = User::find($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent($request);
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = 'Parent Student List';
        return view('admin.parent.my_student', $data);
    }
    public function AssignStudentParent($student_id, $parent_id)
    {
        $student = User::find($student_id);

        $student->parent_id = $parent_id;
        $student->save();
        return redirect()->back()->with('success', 'Student assigned successfully');
    }
    public function AssignStudentParentDelete($student_id)
    {
        $student = User::find($student_id);

        $student->parent_id = null;
        $student->save();
        return redirect()->back()->with('success', 'Student deleted assign successfully');
    }
    public function myStudentParent() 
    {
        $id=Auth::user()->id;
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = 'My Student';
        return view('parent.my_student', $data);
    }
}
