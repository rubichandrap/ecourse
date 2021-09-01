<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

/* IMPORT MODELS */
use App\User;
use App\Kelas;
use App\Session;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $kelas = Kelas::with('user')->withCount('user_joined', 'sessions')->get();
            return view('func.lihatKelas', compact('kelas'))->with('title', 'Kelas');
        } elseif (Auth::user()->hasRole('dosen')) {
            $kelas = Kelas::with('user')->withCount('user_joined', 'sessions')->where('user_id', Auth::user()->id)->get();
            return view('func.lihatKelas', compact('kelas'))->with('title', 'Kelas');
        } else {
            $kelas = Kelas::with('user')->where('status', '1')->whereHas('user_joined', function ($q) {
                $q->where('users.id', Auth::user()->id);
            })->get();
            return view('func.lihatKelasMahasiswa', compact('kelas'))->with('title', 'Kelas');
        }
    }

    public function kelas_list() {
        $kelas = Kelas::with('user')->where('status', '1')->whereHas('user_joined', function ($q) {
            $q->where('users.id', Auth::user()->id);
        })->get();
        return view('func.lihatKelasMahasiswa', compact('kelas'))->with('title', 'Kelas');
    }

    public function ajax_kelas_list()
    {
        $kelas = Kelas::with('user')->where('status', '1')->whereHas('user_joined', function ($q) {
            $q->where('users.id', Auth::user()->id);
        })->get();
        return view('func.ajaxKelasList', compact('kelas'));
    }

    public function kelas_join()
    {
        return view('func.lihatKelasMahasiswa')->with('title', 'Join Kelas');
    }

    public function ajax_kelas_join()
    {
        return view('func.ajaxKelasJoin');
    }

    public function token_handler(Request $request)
    {
        $kelas = Kelas::where('status', '1')->where('token', $request->get('token'))->first();
        $user = User::find(Auth::user()->id);
        if ($kelas) {
            $check_joined = DB::table('user_kelas')->where('user_id', $user->id)->where('kelas_id', $kelas->id)->count();
            if ($check_joined < 1) {
                $user->kelas_joined()->attach($kelas);
                return redirect()->route('kelas.show', $kelas->id)->with('success', 'Selamat! kamu berhasil gabung kelas.');
            }
            else {
                return redirect()->route('kelas.show', $kelas->id)->with('failure', 'Kamu udah tergabung di kelas ini.');
            }
        } else {
            return redirect()->back()->with('failure', 'Mohon maaf, kelas yang kamu cari belum ada.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('func.tambahKelas')->with('title', 'Add Kelas');
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
            'required' => 'Field tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'unique:moduls'],
            'desc' => ['required', 'string'],
            'sessions' => ['required', 'integer', 'max:10'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan, silahkan koreksi.');
        } else {
            $user = User::find(Auth::user()->id);
            $kelas = new Kelas();
            $kelas->user_id = Auth::user()->id;
            $kelas->title = $request->get('title');
            $kelas->desc = $request->get('desc');
            $kelas->sessions = $request->get('sessions');
            $kelas->token = substr(uniqid(), 0, 9);
            if ($request->get('status') == '') {
                $kelas->status = '0';
            } else {
                $kelas->status = $request->get('status');
            }

            $path = 'public/uploads/kelas/'.Str::slug($request->get('title'));
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }

            $kelas->save();
            $kelas->user_joined()->attach($user);
            return redirect()->route('kelas.index')->with('success', 'Data berhasil ditambah');
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
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        return view('func.showKelas', compact('kelas', 'session'))->with('title', $kelas->title);
    }

    public function desc($id)
    {
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        return view('func.showKelas', compact('kelas', 'session'))->with('title', $kelas->title);
    }

    public function ajax_desc($id)
    {
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        return view('func.ajaxKelasDesc', compact('kelas', 'session'));
    }

    public function peserta($id)
    {
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        $user_host = Kelas::with('user')->find($id);
        $user_dosen = User::whereHas('roles', function ($q) {
            $q->where('name', 'dosen');
        })->whereHas('kelas_joined', function ($query) use ($id) {
            $query->where('kelas.id', $id);
        })->get();
        $user_mahasiswa =  User::whereHas('roles', function ($q) {
            $q->where('name', 'mahasiswa');
        })->whereHas('kelas_joined', function ($query) use ($id) {
            $query->where('kelas.id', $id);
        })->get();
        return view('func.showKelas', compact('kelas', 'session', 'user_host', 'user_dosen', 'user_mahasiswa'))->with('title', $kelas->title);
    }

    public function ajax_peserta($id)
    {
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        $user_host = Kelas::with('user')->find($id);
        $user_dosen = User::whereHas('roles', function ($q) {
            $q->where('name', 'dosen');
        })->whereHas('kelas_joined', function ($query) use ($id) {
            $query->where('kelas.id', $id);
        })->get();
        $user_mahasiswa =  User::whereHas('roles', function ($q) {
            $q->where('name', 'mahasiswa');
        })->whereHas('kelas_joined', function ($query) use ($id) {
            $query->where('kelas.id', $id);
        })->get();
        return view('func.ajaxKelasPeserta', compact('kelas', 'session', 'user_host', 'user_dosen', 'user_mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::withCount('sessions')->find($id);
        return view('func.editKelas', compact('kelas'))->with('title', 'Edit Kelas');
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
        $kelas = Kelas::withCount('sessions')->find($id);
        $min_sessions = $kelas->sessions_count;

        $messages = [
            'required' => 'Field tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'unique:moduls'],
            'desc' => ['required', 'string'],
            'sessions' => ['required', 'integer', 'min: ' . $min_sessions],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan, silahkan koreksi input.');
        } else {
            $kelas->title = $request->get('title');
            $kelas->desc = $request->get('desc');
            $kelas->sessions = $request->get('sessions');
            $kelas->save();
            if ($kelas) {
                return redirect()->route('kelas.index')->with('success', 'Data berhasil diubah.');
            } else {
                return back()->withInput()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi');
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
        $kelas = Kelas::find($id);
        $kelas->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function status(Request $request)
    {
        $kelas = Kelas::where('id', $request->get('id'))->first();
        $kelas->status = $request->get('status');
        $kelas->save();
        if ($kelas->status == '0') {
            $status = 'Data berhasil disembunyikan';
        } else {
            $status = 'Data berhasil dipublikasikan';
        }
        if ($kelas) {
            return redirect()->back()->with('success', $status);
        } else {
            return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
        }
    }

    public function kick_peserta($kelas_id, $user_id)
    {
        $user = User::find($user_id);
        $kelas = Kelas::find($kelas_id);
        $user->kelas_joined()->detach($kelas);
        return redirect()->back()->with('success', 'User berhasil ditendang.');
    }
}
