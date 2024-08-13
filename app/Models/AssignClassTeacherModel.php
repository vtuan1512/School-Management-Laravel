<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignClassTeacherModel extends Model
{
    use HasFactory;
    protected $table = 'assign_class_teacher';

    static public function getRecord(\Illuminate\Http\Request $request)
    {
        $query = self::select(
            'assign_class_teacher.*',
            'class.name as class_name',
            'teacher.name as teacher_name',
            'teacher.last_name as teacher_last_name',
            'users.name as created_by_name'
        )
            ->join('users as teacher', 'teacher.id', '=', 'assign_class_teacher.teacher_id')
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('users', 'users.id', '=', 'assign_class_teacher.created_by')
            ->where('assign_class_teacher.is_delete', '=', 0);
        $class_name = $request->get('class_name');
        $teacher_name = $request->get('teacher_name');
        $status = $request->get('status');
        $date = $request->get('date');
        if (!empty($class_name)) {
            $query = $query->where('class.name', 'like', '%' . $class_name . '%');
        }
        if (!empty($teacher_name)) {
            $query = $query->where(function ($query) use ($teacher_name) {
                $query->where('teacher.name', 'like', '%' . $teacher_name . '%')
                    ->orWhere('teacher.last_name', 'like', '%' . $teacher_name . '%');
            });
        }
        if (!empty($status)) {
            $query = $query->where('users.status', '=', $status);
        }

        if (!empty($date)) {
            $query = $query->whereDate('class.created_at', $date);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }

        $return = $query->orderBy('assign_class_teacher.id', 'desc')
            ->paginate(20);

        return $return;
    }
    static public function getMyClassSubject($teacher_id)
    {
        $query = AssignClassTeacherModel::select(
            'assign_class_teacher.*',
            'class.name as class_name',
            'subject.name as subject_name','subject.type as subject_type'
        )
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id' )
            ->join('class_subject', 'class_subject.class_id', '=', 'class.id')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('subject.is_delete', '=', 0)
            ->where('subject.status', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->get();
        return $query;
    }

    static public function getAssignTeacherID($class_id)
    {
        return self::where('class_id', '=', $class_id)->where('is_delete', '=', 0)->get();
    }

    static public function getAlreadyFirst($class_id, $teacher_id)
    {
        return self::where('class_id', '=', $class_id)->where('teacher_id', '=', $teacher_id)->first();
    }
    static public function deleteTeacher($class_id)
    {
        return self::where('class_id', '=', $class_id)->delete();
    }
}
