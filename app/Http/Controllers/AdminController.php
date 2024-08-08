<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecords'] = User::getAdmin($request);
        $data['header_title'] = 'Admin List';
        return view('admin.admin.list', $data);
    }
    public function add()
    {

        $data['header_title'] = 'Add Admin List';
        return view('admin.admin.add', $data);
    }
    public function insert(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->user_type = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin successfully created');
    }
    public function edit($id)
    {
        $data['getRecord'] = User::where('id', $id)->first();
        $data['header_title'] = 'Edit Admin';
        return view('admin.admin.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin successfully updated');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->is_delete = 1;
        $user->save();
        return redirect('admin/admin/list')->with('success', 'Admin successfully deleted');
    }
}
