<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    function index() {
        return view('admin.dashboard');
    }

    function profile () {
        return view('admin.profile.view');
    }

    function updateProfile(Request $request) {
        $request->validate([
            'name' => ['required', 'max:100'],
            'phone' => ['required', 'max:100'],
            'image' => ['required', 'max:2048']
        ]);

        $user = Auth::user();

        if($request->hasFile('image')){
            if(File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }
            $image = $request->image;
            $imageName = rand().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);

            $path = '/uploads/'.$imageName;

            $user->img = $path;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();

            toastr()->success('Profile has been updated successfully!', 'Congrats');
            return redirect()->back();

        }

    }
    
    function updatePassword(){
        return view('admin.password.view');
    }

    function storePassword(Request $request){
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required','confirmed', 'min:8']
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        toastr()->success('Password has been updated successfully!', 'Congrats');
        return redirect()->back();
    }
}
