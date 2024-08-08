<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;
    protected $table = 'subject';

    static public function getRecord(\Illuminate\Http\Request $request)
    {
        $query = SubjectModel::select('subject.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'subject.created_by');

        $name = $request->get('name');
        $date = $request->get('date');
        $type = $request->get('type');
        if (!empty($name)) {
            $query = $query->where('subject.name', 'like', '%' . $name . '%');
        }
        if (!empty($type)) {
            $query = $query->where('subject.type', '=',  $type);
        }
        if (!empty($date)) {
            $query = $query->whereDate('subject.created_at', $date);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }
        $return = $query->where('subject.is_delete', '=', 0)
            ->orderBy('subject.id', 'desc')
            ->paginate(20);
        return $return;
    }
    public static function getSubject()
    {
        $return = SubjectModel::select('subject.*')
            ->join('users', 'users.id', 'subject.created_by')
            ->where('subject.is_delete', '=', 0)
            ->where('subject.status', '=', 0)
            ->orderBy('subject.name', 'asc')
            ->get(20);
        return $return;
    }
}
