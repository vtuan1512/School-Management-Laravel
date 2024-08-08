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
}
