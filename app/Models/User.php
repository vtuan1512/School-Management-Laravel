<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getAdmin(\Illuminate\Http\Request $request)
    {
        $query = self::select('users.*')
            ->where('user_type', '=', 1)
            ->where('is_delete', '=', 0);

        $email = $request->get('email');
        $name = $request->get('name');
        $date = $request->get('date');
        if (!empty($email)) {
            $query = $query->where('email', 'like', '%' . $email . '%');
        }
        if (!empty($name)) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($date)) {
            $query = $query->whereDate('created_at', $date);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }

        $admins = $query->orderBy('id', 'desc')->paginate(10);
        return $admins;
    }
    public static function getStudent(\Illuminate\Http\Request $request)
    {
        $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);
        $email = $request->get('email');
        $name = $request->get('name');
        $last_name = $request->get('last_name');
        $admission_number = $request->get('admission_number');
        $roll_number = $request->get('roll_number');
        $class = $request->get('class');
        $gender = $request->get('gender');
        $caste = $request->get('caste');
        $religion = $request->get('religion');
        $mobile_number = $request->get('mobile_number');
        $height = $request->get('height');
        $weight = $request->get('weight');
        $blood_group = $request->get('blood_group');
        $admission_date = $request->get('admission_date');
        $date = $request->get('date');
        $status = $request->get('status');
        if (!empty($email)) {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }
        if (!empty($name)) {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }
        if (!empty($last_name)) {
            $query = $query->where('users.last_name', 'like', '%' . $last_name . '%');
        }
        if (!empty($admission_number)) {
            $query = $query->where('users.admission_number', 'like', '%' . $admission_number . '%');
        }
        if (!empty($roll_number)) {
            $query = $query->where('users.roll_number', 'like', '%' . $roll_number . '%');
        }
        if (!empty($class)) {
            $query = $query->where('class.name', 'like', '%' . $class . '%');
        }
        if (!empty($gender)) {
            $query = $query->where('users.gender',  '=', $gender);
        }
        if (!empty($caste)) {
            $query = $query->where('users.caste', 'like', '%' . $caste . '%');
        }
        if (!empty($religion)) {
            $query = $query->where('users.religion', 'like', '%' . $religion . '%');
        }
        if (!empty($height)) {
            $query = $query->where('users.height', 'like', '%' . $height . '%');
        }
        if (!empty($weight)) {
            $query = $query->where('users.weight', 'like', '%' . $weight . '%');
        }
        if (!empty($mobile_number)) {
            $query = $query->where('users.mobile_number', 'like', '%' . $mobile_number . '%');
        }
        if (!empty($blood_group)) {
            $query = $query->where('users.blood_group', 'like', '%' . $blood_group . '%');
        }
        if (!empty($admission_date)) {
            $query = $query->whereDate('users.admission_date', $admission_date);
        }
        if (!empty($date)) {
            $query = $query->whereDate('created_at', $date);
        }
        if (!empty($status)) {
            $query = $query->where('users.status', '=', $status);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }

        $admins = $query->orderBy('users.id', 'desc')->paginate(10);
        return $admins;
    }
    public static function getTeacher(\Illuminate\Http\Request $request)
    {
        $query = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0);
        $email = $request->get('email');
        $name = $request->get('name');
        $last_name = $request->get('last_name');
        $gender = $request->get('gender');
        $mobile_number = $request->get('mobile_number');
        $address = $request->get('address');
        $marital_status = $request->get('marital_status');
        $admission_date = $request->get('admission_date');
        $date = $request->get('date');
        $status = $request->get('status');
        if (!empty($email)) {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }
        if (!empty($name)) {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }
        if (!empty($last_name)) {
            $query = $query->where('users.last_name', 'like', '%' . $last_name . '%');
        }
        if (!empty($gender)) {
            $query = $query->where('users.gender',  '=', $gender);
        }
        if (!empty($address)) {
            $query = $query->where('users.address', 'like', '%' . $address . '%');
        }
        if (!empty($marital_status)) {
            $query = $query->where('users.marital_status', 'like', '%' . $marital_status . '%');
        }
        if (!empty($mobile_number)) {
            $query = $query->where('users.mobile_number', 'like', '%' . $mobile_number . '%');
        }
        if (!empty($admission_date)) {
            $query = $query->whereDate('users.admission_date', $admission_date);
        }
        if (!empty($date)) {
            $query = $query->whereDate('created_at', $date);
        }
        if (!empty($status)) {
            $query = $query->where('users.status', '=', $status);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }

        $admins = $query->orderBy('users.id', 'desc')->paginate(10);
        return $admins;
    }

    public static function getParent(\Illuminate\Http\Request $request)
    {
        $query = self::select('users.*')
            ->where('user_type', '=', 4)
            ->where('is_delete', '=', 0);
        $email = $request->get('email');
        $name = $request->get('name');
        $last_name = $request->get('last_name');
        $gender = $request->get('gender');
        $occupation = $request->get('occupation');
        $address = $request->get('address');
        $mobile_number = $request->get('mobile_number');
        $date = $request->get('date');
        $status = $request->get('status');

        if (!empty($email)) {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }
        if (!empty($name)) {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }
        if (!empty($last_name)) {
            $query = $query->where('users.last_name', 'like', '%' . $last_name . '%');
        }
        if (!empty($gender)) {
            $query = $query->where('users.gender',  '=', $gender);
        }
        if (!empty($occupation)) {
            $query = $query->where('users.occupation', 'like', '%' . $occupation . '%');
        }
        if (!empty($address)) {
            $query = $query->where('users.address', 'like', '%' . $address . '%');
        }
        if (!empty($mobile_number)) {
            $query = $query->where('users.mobile_number', 'like', '%' . $mobile_number . '%');
        }
        if (!empty($date)) {
            $query = $query->whereDate('created_at', $date);
        }
        if (!empty($status)) {
            $query = $query->where('users.status', '=', $status);
        }
        $results = $query->get();

        // Check if there are no results and show a message if true
        if ($results->isEmpty()) {
            echo "No data found.";
        }


        $admins = $query->orderBy('id', 'desc')->paginate(10);
        return $admins;
    }

    public static function getTeacherStudent($teacher_id)
    {

        $query = self::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->join('assign_class_teacher', 'assign_class_teacher.id', '=', 'class.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);

        $admins = $query->orderBy('users.id', 'desc')->groupBy('users.id')->paginate(10);
        return $admins;
    }
    public static function getTeacherClass()
    {
        $query = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0);

        $admins = $query->orderBy('users.id', 'desc')->get();
        return $admins;
    }
    static public function getSearchStudent(\Illuminate\Http\Request $request)
    {
        if (!empty($request->get('id')) || !empty($request->get('name')) || !empty($request->get('last_name')) || !empty($request->get('email'))) {
            $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
                ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
                ->join('class', 'class.id', '=', 'users.class_id', 'left')
                ->where('users.user_type', '=', 3)
                ->where('users.is_delete', '=', 0);
            $email = $request->get('email');
            $name = $request->get('name');
            $last_name = $request->get('last_name');
            $id = $request->get('id');
            if (!empty($id)) {
                $query = $query->where('users.id', '=', $id);
            }
            if (!empty($email)) {
                $query = $query->where('users.email', 'like', '%' . $email . '%');
            }
            if (!empty($name)) {
                $query = $query->where('users.name', 'like', '%' . $name . '%');
            }
            if (!empty($last_name)) {
                $query = $query->where('users.last_name', 'like', '%' . $last_name . '%');
            }
            $results = $query->get();
            // Check if there are no results and show a message if true
            if ($results->isEmpty()) {
                echo "No data found.";
            }
            $admins = $query->orderBy('users.id', 'desc')->limit(50)->get();
            return $admins;
        }
    }

    static public function getMyStudent($parent_id)
    {
        $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();
        return $query;
    }


    static public function getEmailSingle($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }
    static public function getTokenSingle($remember_token)
    {
        $user = User::where('remember_token', $remember_token)->first();
        return $user;
    }
    public function getProfile()
    {
        if (!empty($this->profile_pic) && file_exists('uploads/student/' . $this->profile_pic)) {
            return url('uploads/student/' . $this->profile_pic);
        } else {
            return '';
        }
    }
    public function getProfile_Parent()
    {
        if (!empty($this->profile_pic) && file_exists('uploads/parent/' . $this->profile_pic)) {
            return url('uploads/parent/' . $this->profile_pic);
        } else {
            return '';
        }
    }
    public function getProfile_Teacher()
    {
        if (!empty($this->profile_pic) && file_exists('uploads/teacher/' . $this->profile_pic)) {
            return url('uploads/teacher/' . $this->profile_pic);
        } else {
            return '';
        }
    }
}
