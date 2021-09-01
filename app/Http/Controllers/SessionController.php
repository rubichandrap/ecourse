<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* import classes */
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;

/* import model */
use App\Session;
use App\Kelas;
use App\Post;
use App\Comment;

class SessionController extends Controller
{
    public function index($id) {
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        return view('func.showKelas', compact('kelas', 'session'))->with('title', 'Show Kelas');
    }

   public function ajax_session($id) {
        $kelas = Kelas::with('user')->withCount('user_joined')->find($id);
        $session = Session::where('kelas_id', $id)->get();
        return view('func.ajaxKelasSession', compact('kelas', 'session'));
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create($id)
    {
        $kelas_title = Kelas::where('id', $id)->value('title');
        $session_of = intval(Session::where('kelas_id', $id)->count() + 1);
        return view('func.tambahSession', compact('kelas_title', 'session_of', 'id'))->with('title', 'Add Sesi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $messages = [
            'required' => 'Field tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'desc' => ['required', 'string', 'max:255'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $session_of = intval(Session::where('kelas_id', $id)->count() + 1);
            $kelas_title = Kelas::where('id', $id)->value('title');
            $session = new Session();
            $session->kelas_id = $id;
            $session->session_of = $session_of;
            $session->title = 'Pertemuan ' . $session_of;
            $session->desc = $request->get('desc');
            if ($request->get('status') == '') {
                $session->status = '1';
            }
            else {
                $session->status = $request->get('status');
            }

            $path = 'public/uploads/kelas/'.Str::slug($kelas_title).'/'.Str::slug($session->title);
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }

            $session->save();

            return redirect()->route('session.index', $id)->with('success', 'Data berhasil ditambah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $session_of)
    {
        $kelas = Kelas::find($id);
        $session = Session::where('kelas_id', $id)->where('session_of', $session_of)->first();
        $all_session = Session::where('kelas_id', $id)->get();
        $postings = Post::with('user')->where('session_id', $session->id)->latest()->get();
        $comments = Comment::with('user')->whereHas('post', function($q) use ($session){
            $q->where('posts.session_id', $session->id);
        })->latest()->get();
        return view('func.showSession', compact('kelas', 'session', 'all_session', 'postings', 'comments', 'id'))->with('title', 'Show Session');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $session_of)
    {
        $kelas = Kelas::find($id);
        $session = Session::where('kelas_id', $kelas->id)->where('session_of', $session_of)->first();
        return view('func.editSession', compact('kelas', 'session', 'id'))->with('title', 'Edit Sesi');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $session_of)
    {
        $validator = Validator::make($request->all(), [
            'desc' => ['required', 'string'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan input, silahkan koreksi.');
        }
        else {
            $session = Session::where('kelas_id', $request->get('kelas_id'))->where('session_of', $session_of)->first();
            $session->title = $session->title;
            $session->desc = $request->get('desc');
            $session->status = $request->get('status');
            $session->save();

            if ($session) {
                return redirect()->route('kelas.show', $id)->with('success', 'Data berhasil diubah');
            } else {
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
    public function destroy($id, $session_of)
    {
        $session = Session::where('kelas_id', $id)->where('session_of', $session_of)->first();
        $session->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function status(Request $request) {
        $session = Session::where('id', $request->get('id'))->first();
        $session->status = $request->get('status');
        $session->save();
        if($session->status == '0') {
            $status = 'Data berhasil disembunyikan';
        }
        else {
            $status = 'Data berhasil dipublikasikan';
        }
        if ($session) {
            return redirect()->back()->with('success', $status);
        } else {
            return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
        }
    }

}
