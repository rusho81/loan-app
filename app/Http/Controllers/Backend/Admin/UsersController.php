<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    function allUsers(){
        $users = User::latest()->get();
        return view('admin.users.all_users',compact('users'));
    }

    function deleteUser(User $user){
        $user->delete();

        toastr()->success('User deleted successfully!', 'Congrats');
        return redirect()->back();
    }

    function userDetail($id){
        $user = User::findOrFail($id);
        return view('admin.users.detail', compact('user'));
    }

    function toggleRole(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->role = ($request->has('role')) ? 'admin' : 'user';
        $user->save();

        toastr()->success('User role updated successfully!', 'Congrats');
        return redirect()->back();
    }

    function toggleStatus(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->status = ($request->has('status')) ? 'active' : 'inactive';
        $user->save();

        toastr()->success('User status updated successfully!', 'Congrats');
        return redirect()->back();
    }

    
}
