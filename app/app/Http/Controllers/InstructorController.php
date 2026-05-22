<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InstructorController extends Controller
{
    public function InstructorDashboard()
    {
        return view('instructor.content');
     }
    //End Method

     public function InstructorLogin()
    {
        return view('instructor.login');
    }

     public function InstructorProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_profile_view', compact('profileData'));
    }

    public function InstructorProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('images/instructor/' . $data->photo));
                $filename = date('ymdHi') . $file->getClientOriginalName();
                $file->move(public_path('images/instructor'), $filename);
                $data['photo'] = $filename;
            }
        $data->save();

        $notification = array(
            'message' => 'Instructor Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification) ;
    }

     public function InstructorResetPassword(Request $request)
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.reset-password', compact('profileData'));
    }

    public function InstructorUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {

            $notification = array(
                'message' => 'Old Password Does Not Match',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            User::whereId(Auth::user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            $notification = array(
                'message' => 'Password Updated Successfully',
                'alert-type' => 'success'
            );

            return back()->with($notification);

        }


    }

    public function InstructorLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/instructor/login');
    }
}
