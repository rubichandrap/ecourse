<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */
use Illuminate\Validation\Rule;
use Auth;

/* IMPORT MODEL */
use App\User;
use App\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->with('roles', 'majors')->first();
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        return view('func.userProfile', compact(['user', 'profile']))->with('title', 'Profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);
        $profile->tempat_lahir = $request->get('tempat_lahir');
        $profile->tanggal_lahir = $request->get('tanggal_lahir');
        $profile->pekerjaan = $request->get('pekerjaan');
        $profile->alamat = $request->get('alamat');
        $profile->about = $request->get('about');
        $profile->save();
        
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
