<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectModel extends Model
{
    use HasFactory;
    protected $table = 'class_subject';
    static public function getRecord(\Illuminate\Http\Request $request)
    {
        $query = self::select('class_subject.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as created_by_name')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->join('users', 'users.id', '=', 'class_subject.created_by')
            ->where('class_subject.is_delete', '=',0);
        $class_name = $request->get('class_name');
        $subject_name = $request->get('subject_name');
        $date = $request->get('date');
        if (!empty($class_name)) {
            $query = $query->where('class.name', 'like', '%' . $class_name . '%');
        }
        if (!empty($subject_name)) {
            $query = $query->where('subject.name', 'like', '%' . $subject_name . '%');
        }
        if (!empty($date)) {
            $query = $query->whereDate('class_subject.created_at', $date);
        }
        $results = $query->get();
        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }

        $return = $query->orderBy('class_subject.id', 'desc')
            ->paginate(20);

        return $return;
    }
    static public function getAlreadyFirst($class_id, $subject_id)
    {
        return self::where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }
    static public function getAssignSubjectID($class_id)
    {
        return self::where('class_id', '=', $class_id)->where('is_delete','=',0)->get();
    }
    static public function deleteSubject($class_id)
    {
        return self::where('class_id', '=', $class_id)->delete();
    }
    static public function MySubject($class_id)
    {
        return self::select('class_subject.*', 'subject.name as subject_name','subject.type as subject_type')
        ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
        ->join('class', 'class.id', '=', 'class_subject.class_id')
        ->join('users', 'users.id', '=', 'class_subject.created_by')
        ->where('class_subject.class_id','=',$class_id)
        ->where('class_subject.is_delete', '=',0)
        ->where('class_subject.status', '=',0)
        ->orderBy('class_subject.id', 'desc')
        ->get();
    }
}
