<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

/* IMPORT MODEL */
use App\User;
use App\Role;
use App\Major;
use App\Profile;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = User::with('roles', 'majors')->whereHas('roles', function ($q) {
            $q->where('name', 'dosen');
        })->get();
        return view('func.lihatDosen', compact('dosen'))->with('title', 'Dosen');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('func.tambahDosen')->with('title', 'Add Dosen');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'nbm_nim.required' => 'The NIM field is required.',
            'nbm_nim.min' => 'NIM yang diinput tidak valid.',
            'nbm_nim.max' => 'NIM yang diinput tidak valid.',
            'nbm_nim.regex' => 'Karakter yang diinput hanya boleh angka.',
        ];

        $validator = Validator::make($request->all(), [
            'nbm_nim' => ['required', 'string', 'min:6', 'max:10', 'unique:users', 'regex:/^[0-9]*$/'],
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan input, silahkan koreksi.');
        } else {
            $role = Role::where('name', 'dosen')->first();

            $arr_user = User::all()->toArray();
            $user_id = $arr_user[User::count() - 1]['id'];

            $dosen = new User();
            $dosen->nbm_nim = $request->get('nbm_nim');
            $dosen->name = $request->get('name');
            $dosen->username = substr(uniqid(), 0, 7) . intval($user_id + 1) . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -5, 2);
            $dosen->email = $request->get('email');
            $dosen->password = Hash::make(substr(uniqid(), 0));
            $dosen->save();
            $dosen->assignRoles($role);
            $dosen->profile()->save(new Profile);
            
            if ($dosen) {
                return redirect()->route('dosen.index')->with('success', 'Data berhasil ditambah.');
            }
            else {
                return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dosen = User::with('roles', 'majors')->find($id);
        $profile = Profile::where('user_id', $id)->first();
        return view('func.showDosen', compact(['dosen', 'profile']))->with('title', 'Show Dosen');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dosen = User::with('roles', 'majors')->find($id);
        $profile = Profile::where('user_id', $id)->first();
        return view('func.editDosen', compact(['dosen', 'profile', 'id']))->with('title', 'Edit Dosen');
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
        $messages = [
            'nbm_nim.required' => 'The NBM field is required.',
            'nbm_nim.min' => 'NIM yang diinput tidak valid.',
            'nbm_nim.max' => 'NIM yang diinput tidak valid.',
            'nbm_nim.regex' => 'Karakter yang diinput hanya boleh angka.',
        ];

        $validator = Validator::make($request->all(), [
            'nbm_nim' => ['required', 'string', 'min:6', 'max:10', 'unique:users,nbm_nim,' . $id, 'regex:/^[0-9]*$/'],
            'username' => ['required', 'string', 'max:12', 'unique:users,username,' . $id],
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'string', 'max:255'],
        ], $messages);

        $notInZero = Rule::notIn(['', '0']);

        $validator->sometimes('major', 'required|string|max:255|'.$notInZero, function($input) {
            return $input->role == 'mahasiswa';
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan, silahkan koreksi.');
        } else {
            $mahasiswa = User::find($id);
            $role = Role::where('name', $request->get('role'))->first(); //destructuring

            $mahasiswa->nbm_nim = $request->get('nbm_nim');
            $mahasiswa->username = $request->get('username');
            $mahasiswa->name = $request->get('name');
            $mahasiswa->email = $request->get('email');
            $mahasiswa->status = $request->get('status');

            $mahasiswa->save();
            $mahasiswa->roles()->newPivotStatement()->where('user_id', $id)->update(['role_id' => $role->id]);

            if ($request->get('role') == 'mahasiswa') {
                $major = Major::where('name', $request->get('major'))->first(); //destructuring
                $mahasiswa->majors()->attach($major);
            }

            if ($mahasiswa) {
                return redirect()->route('dosen.index')->with('success', 'Data berhasil diubah');
            }
            else {
                return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dosen = User::find($id);
        $dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
