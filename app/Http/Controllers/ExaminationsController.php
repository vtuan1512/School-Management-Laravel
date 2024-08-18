<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationsController extends Controller
{
    public function exam_list(Request $request)
    {
        $data['getRecords'] = ExamModel::getRecord($request);
        $data['header_title'] = 'Exam List';
        return view('admin.examinations.exam.list', $data);
    }
    public function exam_add()
    {
        $data['header_title'] = 'Add New Exam ';
        return view('admin.examinations.exam.add', $data);
    }
    public function exam_insert(Request $request)
    {
        $exam = new ExamModel();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;
        $exam->save();
        return redirect('admin/examinations/exam/list')->with('success', 'Exam added successfully');
    }
    public function exam_edit($id)
    {
        $data['header_title'] = 'Edit Exam';
        $data['getRecords'] = ExamModel::find($id);
        return view('admin.examinations.exam.edit', $data);
    }
    public function exam_update(Request $request, $id)
    {
        $exam = ExamModel::find($id);
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->save();
        return redirect('admin/examinations/exam/list')->with('success', 'Exam updated successfully');
    }
    public function exam_delete($id)
    {
        $exam = ExamModel::find($id);
        if ($exam) {
            $exam->is_delete = 1;
            $exam->save();
        }
        return redirect('admin/examinations/exam/list')->with('success', 'Exam marked as deleted successfully');
    }
    public function exam_schedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        $result = array();
        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
            $getSubject = ClassSubjectModel::MySubject($request->get('class_id'));
            foreach ($getSubject as $value) {
                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['class_id'] = $value->class_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;
                $ExamSchedule = ExamScheduleModel::getRecordSingle($value->subject_id, $request->get('class_id'), $request->get('exam_id'));
                if (!empty($ExamSchedule)) {
                    $dataS['exam_date'] = $ExamSchedule->exam_date;
                    $dataS['start_time'] = $ExamSchedule->start_time;
                    $dataS['end_time'] = $ExamSchedule->end_time;
                    $dataS['room_number'] = $ExamSchedule->room_number;
                    $dataS['full_marks'] = $ExamSchedule->full_marks;
                    $dataS['passing_mark'] = $ExamSchedule->passing_mark;
                } else {
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['room_number'] = '';
                    $dataS['full_marks'] = '';
                    $dataS['passing_mark'] = '';
                }
                $result[] = $dataS;
            }
        }
        $data['getRecords'] = $result;
        $data['header_title'] = 'Exam Schedule';
        return view('admin.examinations.exam_schedule', $data);
    }
    public function exam_schedule_insert(Request $request)
    {
        ExamScheduleModel::where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->delete();

        if (!empty($request->schedule)) {
            foreach ($request->schedule as $value) {
                if (
                    !empty($value['subject_id']) && !empty($value['exam_date']) && !empty($value['start_time']) && !empty($value['end_time']) && !empty($value['room_number']) &&
                    !empty($value['full_marks']) && !empty($value['passing_mark'])
                ) {
                    $schedule = new ExamScheduleModel();
                    $schedule->exam_id = $request->exam_id;
                    $schedule->class_id = $request->class_id;
                    $schedule->subject_id = $value['subject_id'];
                    $schedule->exam_date = $value['exam_date'];
                    $schedule->start_time = $value['start_time'];
                    $schedule->end_time = $value['end_time'];
                    $schedule->room_number = $value['room_number'];
                    $schedule->full_marks = $value['full_marks'];
                    $schedule->passing_mark = $value['passing_mark'];
                    $schedule->created_by = Auth::user()->id;
                    $schedule->save();
                }
            }
            return redirect()->back()->with('success', 'Exam schedule added successfully');
        }
    }


    //student side
    public function MyExamTimetable()
    {
        $class_id = Auth::user()->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();
            foreach ($getExamTimetable as $valueS) {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_mark'] = $valueS->passing_mark;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        $data['getRecords'] = $result;
        $data['header_title'] = 'My Exam Timetable';
        return view('student.my_exam_timetable', $data);
    }

    //teacher side
    public function MyExamTimetableTeacher()
    {
        $result = array();
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        foreach ($getClass as $class) {
            $dataC = array();
            $dataC['class_name'] = $class->class_name;
            $getExam = ExamScheduleModel::getExam($class->class_id);
            $examArray = array();
            foreach ($getExam as $exam) {
                $dataE = array();
                $dataE['exam_name'] = $exam->exam_name;

                $getExamTimetable = ExamScheduleModel::getExamTimetable($exam->exam_id, $class->class_id);
                $subjectArray = array();
                foreach ($getExamTimetable as $valueS) {
                    $dataS = array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_marks'] = $valueS->full_marks;
                    $dataS['passing_mark'] = $valueS->passing_mark;
                    $subjectArray[] = $dataS;
                }
                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;
            }
            $dataC['exam'] = $examArray;
            $result[] = $dataC;
        }
        $data['getRecords'] = $result;
        $data['header_title'] = 'My Exam Timetable';
        return view('teacher.my_exam_timetable', $data);
    }
    //Parent side
    public function MyExamTimetableParent($student_id)
    {
        $getStudent = User::find($student_id);
        $class_id = $getStudent->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();
            foreach ($getExamTimetable as $valueS) {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_mark'] = $valueS->passing_mark;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        $data['getRecords'] = $result;
        $data['getStudent'] = $getStudent;
        $data['header_title'] = 'Exam Timetable';
        return view('parent.exam_timetable', $data);
    }
}
