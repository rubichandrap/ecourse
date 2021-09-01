<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Absent;
use App\Kelas;
use App\Session;
use App\User;

class AbsentController extends Controller
{
  // tes commenting for commit

    public function index($kelas_id, $session_of) {
        $kelas = Kelas::find($kelas_id);
        $session = Session::where('kelas_id', $kelas_id)->where('session_of', $session_of)->first();
        $all_session = Session::where('kelas_id', $kelas_id)->get();
        $users  = User::whereHas('kelas_joined', function($q) use ($kelas_id) {
            $q->where('kelas.id', $kelas_id);
        })->get();
        $absent = Absent::where('user_id', Auth::user()->id)->where('kelas_id', $kelas_id)->where('session_id', $session->id)->count();

        $arr_absents = [];
        $is_peserta = false;
        foreach($users as $key) {
            $list_absents = Absent::where('user_id', $key->id)->where('kelas_id', $kelas_id)->where('session_id', $session->id)->first();
            $arr_absents[$key->id] = $list_absents;

            /* user [1,2,3]  // user yang join kelas ada 3 orang, id 1,2 ,3

            absen [1,3] // yang absen baru 1,3

            arr_absents[
                1 = [
                    user_id, kelas_id,
                ]
                2 = null,
                3 = [
                    user_id,
                ]
            ]

            jadi skrng apabila di isset($arr_absents[1] || $arr_absents[3]) hasilnya adalah true

            namun isset($arr_absents[2]) hasilnya false.

            */

            if(Auth::user()->id == $key->id) {
                $is_peserta = true;
            }

            /* andai yang terdaftar di kelas ada 2, id => 1, nama => bambang, ters id => 2, nama => tejo
                yang terjadi adalah, controller melakukan pengecekan terhadap Auth user()->id ada atau tidak dalam array users
                apabila ada, variabel is peserta adalah true, yang artinya, user yang sedang login saat ini, merupakan peserta kelas,
                selainnya dianggap false.
            */

        }

        return view('func.showSession', compact('kelas', 'session', 'all_session', 'users', 'absent', 'arr_absents', 'is_peserta', 'kelas_id'))->with('title', 'Show Absen');
    }

    public function store(Request $request, $kelas_id, $session_of)
    {
        $kelas = Kelas::find($kelas_id);
        $session = Session::where('kelas_id', $kelas->id)->where('session_of', $session_of)->first();

        $exist = Absent::where('user_id', Auth::user()->id)->where('kelas_id', $kelas->id)->where('session_id', $session->id)->count();

        if ($exist > 0) {
            return redirect()->back()->with('failure', 'Kamu ga bisa absen lagi.');
        } else {
            $absent = new Absent();
            $absent->user_id = Auth::user()->id;
            $absent->kelas_id = $kelas->id;
            $absent->session_id = $session->id;
            $absent->status = $request->get('status');
            $absent->save();

            if ($absent) {
                return redirect()->back()->with('success', 'Kamu berhasil absen.');
            } else {
                return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
            }
        }
    }
}
