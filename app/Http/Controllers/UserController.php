<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function MyAccount()
    {
        $data['getRecord'] = User::find(Auth::user()->id);
        $data['header_title'] = 'My Account';
        if (Auth::user()->user_type == 1) {
            return view('admin.my_account', $data);
        } else if (Auth::user()->user_type == 2) {
            return view('teacher.my_account', $data);
        } else if (Auth::user()->user_type == 3) {
            return view('student.my_account', $data);
        } else if (Auth::user()->user_type == 4) {
            return view('parent.my_account', $data);
        }
    }
    public function UpdateMyAccountAdmin(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Account successfully updated');
    }
    public function UpdateMyAccount(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:8',
        ]);

        $teacher = User::find($id);
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $teacher->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            if (!empty($teacher->getProfile_Teacher())) {
                unlink('uploads/teacher/' . $teacher->profile_pic);  // delete old file before uploading new one
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('uploads/teacher/', $fileName);
            $teacher->profile_pic = $fileName;
        }
        $teacher->marital_status = trim($request->marital_status);
        $teacher->permanent_address = trim($request->permanent_address);
        $teacher->address = trim($request->address);
        $teacher->mobile_number = trim($request->mobile_number);
        $teacher->qualification = trim($request->qualification);
        $teacher->work_experience = trim($request->work_experience);
        $teacher->email = trim($request->email);
        $teacher->save();
        return redirect()->back()->with('success', 'Account updated successfully');
    }
    public function UpdateMyAccountStudent(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'height' => 'max:10',
            'weight' => 'max:10',
            'caste' => 'max:50',
            'religion' => 'max:50',
            'mobile_number' => 'max:15|min:8',
            'blood_group' => 'max:10'
        ]);

        $student = User::find($id);
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->gender = trim($request->gender);
        if (!empty($request->date_of_birth)) {
            $student->date_of_birth = trim($request->date_of_birth);
        }
        if (!empty($request->file('profile_pic'))) {
            if (!empty($student->getProfile())) {
                unlink('uploads/student/' . $student->profile_pic);  // delete old file before uploading new one
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('uploads/student/', $fileName);
            $student->profile_pic = $fileName;
        }
        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);
        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->email = trim($request->email);
        $student->save();
        return redirect()->back()->with('success', 'Account updated successfully');
    }
    public function UpdateMyAccountParent(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'max:255',
            'mobile_number' => 'max:15|min:8',
            'occupation' => 'max:255',
        ]);
        $parent = User::find($id);
        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);
        $parent->occupation = trim($request->occupation);
        $parent->address = trim($request->address);
        if (!empty($request->file('profile_pic'))) {
            if (!empty($parent->getProfile_Parent())) {
                unlink('uploads/parent/' . $parent->profile_pic);  // delete old file before uploading new one
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('uploads/parent/', $fileName);
            $parent->profile_pic = $fileName;
        }
        $parent->mobile_number = trim($request->mobile_number);
        $parent->email = trim($request->email);
        $parent->save();
        return redirect()->back()->with('success', 'Parent updated successfully');
    }
    public function change_password()
    {
        $data['header_title'] = 'Change Password';
        return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
        $user = User::where('id', auth()->id())->first();
        if ($user && Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Password has been updated successfully');
        } else {
            return redirect()->back()->with('error', 'Old password does not match');
        }
    }
}
