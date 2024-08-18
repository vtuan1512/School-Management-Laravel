<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamModel extends Model
{
    use HasFactory;

    protected $table = "exam";

    static public function getRecord(\Illuminate\Http\Request $request)
    {
        $query = self::select('exam.*', 'users.name as created_name')
            ->join('users', 'users.id', '=', 'exam.created_by');
        $name = $request->get('name');
        $date = $request->get('date');
        if (!empty($name)) {
            $query = $query->where('exam.name', 'like', '%' . $name . '%');
        }
        if (!empty($date)) {
            $query = $query->whereDate('exam.created_at', $date);
        }
        $results = $query->get();
       
        $exam = $query->where('exam.is_delete', '=', 0)
            ->orderBy('exam.id', 'desc')
            ->paginate(50);

        return $exam;
    }
    static public function getExam()
    {
        $query = self::select('exam.*')
            ->join('users', 'users.id', '=', 'exam.created_by')
            ->where('exam.is_delete', '=', 0)
            ->orderBy('exam.name', 'desc')
            ->get();

        return $query;
    }
}
