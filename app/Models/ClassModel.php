<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

    static public function getRecord(\Illuminate\Http\Request $request)
    {
        $query = ClassModel::select('class.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'class.created_by');

        $name = $request->get('name');
        $date = $request->get('date');
        if (!empty($name)) {
            $query = $query->where('class.name', 'like', '%' . $name . '%');
        }
        if (!empty($date)) {
            $query = $query->whereDate('class.created_at', $date);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }
        $return = $query->where('class.is_delete', '=', 0)
            ->orderBy('class.id', 'desc')
            ->paginate(20);
        return $return;
    }
    public static function getClass()
    {
        $query = ClassModel::select('class.*')
            ->join('users', 'users.id', '=', 'class.created_by')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->orderBy('class.name', 'asc')
            ->limit(20)
            ->get();
        return $query;
    }
}
