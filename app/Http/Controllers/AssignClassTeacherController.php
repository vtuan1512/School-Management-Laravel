<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignClassTeacherController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = AssignClassTeacherModel::getRecord($request);
        $data['header_title'] = 'Assign Class Teacher';
        return view('admin.assign_class_teacher.list', $data);
    }
    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = 'Assign Class Teacher Add ';
        return view('admin.assign_class_teacher.add', $data);
    }
    public function insert(Request $request)
    {
        if (!empty($request->teacher_id)) {
            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_class_teacher/list')->with('success', 'Assign Class to Techer Successful');
        } else {
            return redirect()->back()->with('error', 'Due to some error pls try again');
        }
    }
    public function edit($id)
    {
        $data['getRecord'] = AssignClassTeacherModel::where('id', $id)->first();
        $data['getAssignTeacherID'] = AssignClassTeacherModel::getAssignTeacherID($data['getRecord']->class_id, $data['getRecord']->subject_id);
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = 'Assign Class Teacher Edit ';
        return view('admin.assign_class_teacher.edit', $data);
    }
    public function update(Request $request, $id)
    {
        AssignClassTeacherModel::deleteTeacher($request->class_id);
        if (!empty($request->teacher_id)) {
            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_class_teacher/list')->with('success', 'Assign Class to Techer Successful');
        }
    }
    public function edit_single($id)
    {
        $data['getRecord'] = AssignClassTeacherModel::where('id', $id)->first();
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = 'Assign Class Teacher Edit ';
        return view('admin.assign_class_teacher.edit_single', $data);
    }
    public function update_single(Request $request, $id)
    {

        $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $request->teacher_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();
            return redirect('admin/assign_class_teacher/list')->with('success', 'Status Successfully Updated');

        } else {
            $save = AssignClassTeacherModel::where('id', $id)->first();;
            $save->class_id = $request->class_id;
            $save->teacher_id = $request->teacher_id;
            $save->status = $request->status;
            $save->save();
            return redirect('admin/assign_class_teacher/list')->with('success', 'Subject Successfully Assign to Class');
        }
    }
    public function delete($id)
    {
        $save = AssignClassTeacherModel::find($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success', 'Class successfully deleted');
    }
    //teacher side
    public function MyClassSubject( )
    {
        $data['getRecord'] = AssignClassTeacherModel::getMyClassSubject(Auth::user()->id);
        $data['header_title'] = 'My Class & Subject   ';
        return view('teacher.my_class_subject', $data);
    }
}
