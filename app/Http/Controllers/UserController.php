<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function change_password()
    {
        $data['header_title'] = 'Change Password';
        return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
        $user = User::where('id', auth()->id())->first(); // Ensure you fetch the correct user
        if ($user && Hash::check($request->old_password, $user->password)) 
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Password has been updated successfully');
        } 
        else 
        {
            return redirect()->back()->with('error', 'Old password does not match');
        }
    }
}
