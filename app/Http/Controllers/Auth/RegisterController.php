<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/* IMPORT CLASSES */
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

/* IMPORT MODEL */
use App\User;
use App\Role;
use App\Profile;
use App\Major;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'required' => 'Field tidak boleh kosong',
            'nbm_nim.min' => 'NIM yang diinput tidak valid',
            'nbm_nim.max' => 'NIM yang diinput tidak valid',
            'nbm_nim.regex' => 'Input hanya boleh angka',
        ];

        return Validator::make($data, [
            'nbm_nim' => ['required', 'string', 'min:6', 'max:10', 'regex:/^[0-9]*$/'],
            'username' => ['required', 'string', 'min:4', 'max:12', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
    }

    protected function update(array $data)
    {
        $user = User::where('nbm_nim', $data['nbm_nim'])->first();
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->status = '1';
        $user->register = '1';
        $user->save();
        return $user;
    }

    public function showRegistrationForm()
    {
        return view('auth.register')->with('title', 'Register');
    }   

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user_validate = User::where('nbm_nim', $request->get('nbm_nim'));
        $user_count = $user_validate->count();

        if ($user_count > 0) {
            $user = $user_validate->first();
            $role = Role::whereHas('users', function ($q) use ($request) {
                $q->where('users.nbm_nim', $request->get('nbm_nim'));
            })->first();
            $major = Major::whereHas('users', function ($q) use ($request) {
                $q->where('users.nbm_nim', $request->get('nbm_nim'));
            })->first();
            if ($user->nbm_nim == $request->get('nbm_nim') && $user->email == $request->get('email')) {
                if ($role->name == 'mahasiswa' && $major->name == $request->get('major')) {
                        if ($user->register == '0') {
                            event(new Registered($user = $this->update($request->all())));
                            $this->guard()->login($user);
                            return $this->registered($request, $user) ?: redirect($this->redirectPath());
                        } else {
                            return redirect()->back()->withInput()->with('failure', 'Hanya dapat melakukan registrasi sekali.');
                        }
                } elseif ($role->name != 'mahasiswa' && $request->get('major') == '') {
                    if ($user->register == '0') {
                        event(new Registered($user = $this->update($request->all())));
                        $this->guard()->login($user);
                        return $this->registered($request, $user) ?: redirect($this->redirectPath());
                    } else {
                        return redirect()->back()->withInput()->with('failure', 'Hanya dapat melakukan registrasi sekali.');
                    }
                }
                else {
                    return redirect()->back()->withInput()->with('failure', 'Anda belum terdaftar Silahkan Hubungi Admin 1.');
                }
            } else {
                return redirect()->back()->withInput()->with('failure', 'Anda belum terdaftar Silahkan Hubungi Admin 2.');
            }
        }
        else {
            return redirect()->back()->withInput()->with('failure', 'Anda belum terdaftar Silahkan Hubungi Admin 3.');
        }
    }
}
