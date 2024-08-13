<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class TeacherController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecords'] = User::getTeacher($request);
        $data['header_title'] = 'Teacher List';
        return view('admin.teacher.list', $data);
    }
    public function add()
    {
        $data['header_title'] = 'Add Teacher';
        return view('admin.teacher.add', $data);
    }
    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' => 'max:15|min:8',

        ]);

        $teacher = new User();
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $teacher->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('uploads/teacher/', $fileName);
            $teacher->profile_pic = $fileName;
        }
        $teacher->marital_status = trim($request->marital_status);
        $teacher->permanent_address = trim($request->permanent_address);
        $teacher->address = trim($request->address);
        $teacher->mobile_number = trim($request->mobile_number);
        if (!empty($request->admission_date)) {
            $teacher->admission_date = trim($request->admission_date);
        }

        $teacher->qualification = trim($request->qualification);
        $teacher->work_experience = trim($request->work_experience);
        $teacher->note = trim($request->note);
        $teacher->status = trim($request->status);
        $teacher->email = trim($request->email);
        $teacher->password = Hash::make($request->password);
        $teacher->user_type = 2;
        $teacher->save();
        return redirect('admin/teacher/list')->with('success', 'Teacher added successfully');
    }
    public function edit($id)
    {
        $data['getRecord'] = User::find($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Teacher';
            return view('admin.teacher.edit', $data);
        } else {
            abort(404);
        }
    }
    public function update(Request $request, $id)
    { {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $id,
                'mobile_number' => 'max:15|min:8',
            ]);

            $teacher = User::find($id);
            $teacher->name = trim($request->name);
            $teacher->last_name = trim($request->last_name);
            $teacher->gender = trim($request->gender);
            if (!empty($request->date_of_birth)) {
                $teacher->date_of_birth = trim($request->date_of_birth);
            }
            if (!empty($request->file('profile_pic'))) {
                if (!empty($teacher->getProfile_Teacher())) {
                    unlink('uploads/teacher/' . $teacher->profile_pic);  // delete old file before uploading new one
                }
                $ext = $request->file('profile_pic')->getClientOriginalExtension();
                $file = $request->file('profile_pic');
                $randomStr = date('Ymdhis') . Str::random(20);
                $fileName = strtolower($randomStr) . '.' . $ext;
                $file->move('uploads/teacher/', $fileName);
                $teacher->profile_pic = $fileName;
            }
            $teacher->marital_status = trim($request->marital_status);
            $teacher->permanent_address = trim($request->permanent_address);
            $teacher->address = trim($request->address);
            $teacher->mobile_number = trim($request->mobile_number);
            if (!empty($request->admission_date)) {
                $teacher->admission_date = trim($request->admission_date);
            }

            $teacher->qualification = trim($request->qualification);
            $teacher->work_experience = trim($request->work_experience);
            $teacher->note = trim($request->note);
            $teacher->status = trim($request->status);
            $teacher->email = trim($request->email);

            if (!empty($request->password)) {
                $teacher->password = Hash::make($request->password);
            }
            $teacher->save();
            return redirect('admin/teacher/list')->with('success', 'Teacher updated successfully');
        }
    }
    public function delete($id)
    {
        $teacher = User::find($id);
        if (!empty($teacher)) 
        {
            $teacher->is_delete=1;
            $teacher->save();
            return redirect()->back()->with('success', 'Teacher deleted successfully');
        } else {
            abort(404);
        }
    }
}
