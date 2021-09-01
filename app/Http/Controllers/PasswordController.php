<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

/* IMPORT MODEL */
use App\User;
use App\Profile;

class PasswordController extends Controller
{   
    public function edit($id)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        return view('func.editPassword', compact(['user', 'profile']))->with('title', 'Edit Password');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user_data = User::where('id', Auth::user()->id)->first();
            if ($user_data->username == $request->get('username')  && Hash::check($request->get('current_password'), Auth::user()->password)) {
                $user_data->password = Hash::make($request->get('password'));
                $user_data->save();
                $status = 'success';
                return redirect()->route('profile.index')->with($status, 'Password berhasil diubah');
            } else {
                $status = 'failure';
                return redirect()->back()->with($status, 'Mohon masukkan username dan current password dengan benar');
            }
            return redirect()->back()->with($status, $notif);
        }
    }
}
