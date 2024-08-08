<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassSubjectController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = ClassSubjectModel::getRecord($request);
        $data['header_title'] = 'Assign Subject List';
        return view('admin.assign_subject.list', $data);
    }
    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = ' Assign Subject Add ';
        return view('admin.assign_subject.add', $data);
    }
    public function insert(Request $request)
    {
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/assign_subject/list')->with('success', 'Subject Successfully Assign to Class');
        } else {
            return redirect()->back()->with('error', 'Due to some error pls try again');
        }
    }
    public function delete($id)
    {
        $save = ClassSubjectModel::find($id);
        $save->is_delete = 1;
        $save->save();
        return redirect()->back()->with('success', 'Class successfully deleted');
    }
    public function edit($id)
    {
        $data['getRecord'] = ClassSubjectModel::where('id', $id)->first();
        $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($data['getRecord']->class_id, $data['getRecord']->subject_id);
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = 'Assign Subject Edit ';
        return view('admin.assign_subject.edit', $data);
    }
    public function update(Request $request)
    {
        ClassSubjectModel::deleteSubject($request->class_id);
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
        }
        return redirect('admin/assign_subject/list')->with('success', 'Subject Successfully Update');
    }
    public function edit_single($id)
    {
        $data['getRecord'] = ClassSubjectModel::where('id', $id)->first();
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = 'Assign Subject Edit ';
        return view('admin.assign_subject.edit_single', $data);
    }
    public function update_single(Request $request, $id)
    {

        $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $request->subject_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();
            return redirect('admin/assign_subject/list')->with('success', 'Status Successfully Updated');

        } else {
            $save = ClassSubjectModel::where('id', $id)->first();;
            $save->class_id = $request->class_id;
            $save->subject_id = $request->subject_id;
            $save->status = $request->status;
            $save->save();
            return redirect('admin/assign_subject/list')->with('success', 'Subject Successfully Assign to Class');
        }
    }
}
