<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

/* IMPORT MODEL */
use App\User;
use App\Modul;
use App\Lecture;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($slug)
    {
        $modul = Modul::where('slug', $slug)->first();
        $lecture = Lecture::where('modul_id', $modul->id)->where('status', '1')->count();
        $list = Lecture::where('modul_id', $modul->id)->where('status', '1')->get();
        $unpublish = Lecture::where('modul_id', $modul->id)->where('status', '0')->get();
        $learn_sum = DB::table('user_lectures')->where('user_id', Auth::user()->id)->get();
        $learn_status = [];
        foreach ($learn_sum as $key) {
            $learn_status[$key->lecture_id] = $key->user_id;
        }
        return view('func.showModul', compact('modul', 'lecture', 'list', 'unpublish', 'learn_status'))->with('title', $modul->title);
    }

    /* ajax materi */

    public function ajax_lecture($slug)
    {
        $modul = Modul::where('slug', $slug)->first();
        $lecture = Lecture::where('modul_id', $modul->id)->where('status', '1')->count();
        $list = Lecture::where('modul_id', $modul->id)->where('status', '1')->get();
        $unpublish = Lecture::where('modul_id', $modul->id)->where('status', '0')->get();
        $learn_sum = DB::table('user_lectures')->where('user_id', Auth::user()->id)->get();
        $learn_status = [];
        foreach ($learn_sum as $key) {
            $learn_status[$key->lecture_id] = $key->user_id;
        }
        return view('func.ajaxModulMateri', compact('modul', 'lecture', 'list', 'unpublish', 'learn_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $modul_id = Modul::where('slug', $slug)->value('id');
        $modul_title = Modul::where('slug', $slug)->value('title');
        return view('func.tambahMateri', compact('modul_id', 'modul_title', 'slug'))->with('title', 'Add Materi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $messages = [
            'required' => 'Field tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $urutan = Lecture::where('modul_id', $request->get('modul_id'))->count();
            $lecture = new Lecture();
            $lecture->user_id = Auth::user()->id;
            $lecture->modul_id = $request->get('modul_id');
            $lecture->title = $request->get('title');
            $lecture->content = $request->get('content');
            $lecture->urutan = $urutan + 1;
            if ($request->get('status') == '') {
                $lecture->status = '0';
            } else {
                $lecture->status = $request->get('status');
            }
            $lecture->save();

            return redirect()->route('modul.show', $slug)->with('success', 'Data berhasil ditambah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $urutan)
    {
        $modul = Modul::where('slug', $slug)->first();
        $lecture = Lecture::where('modul_id', $modul->id)->where('status', '1')->get();
        $detail = Lecture::where('modul_id', $modul->id)->where('urutan', $urutan)->first();
        $user = User::find(Auth::user()->id);
        $learn_count = DB::table('user_lectures')->where('user_id', Auth::user()->id)->where('lecture_id', $detail->id)->count();
        if($learn_count == 0) {
            $user->lectures()->attach($detail);
        }
        $learn_sum = DB::table('user_lectures')->where('user_id', Auth::user()->id)->get();
        $learn_status = [];
        foreach ($learn_sum as $key) {
            $learn_status[$key->lecture_id] = $key->user_id;
        }
        return view('func.showMateri', compact('detail', 'modul', 'lecture', 'learn_status'))->with('title', 'Show Materi');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, $urutan)
    {
        $modul = Modul::where('slug', $slug)->first();
        $modul_id = $modul->id;
        $lecture = Lecture::where('modul_id', $modul_id)->where('urutan', $urutan)->first();
        $detail = Lecture::where('modul_id', $modul->id)->where('urutan', $urutan)->first();
        return view('func.editMateri', compact('modul', 'modul_id', 'lecture', 'detail', 'slug'))->with('title', 'Edit Materi');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $urutan)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan input, silahkan koreksi.');
        }
        else {
            $lecture = Lecture::where('modul_id', $request->get('modul_id'))->where('urutan', $urutan)->first();
            $lecture->title = $request->get('title');
            $lecture->content = $request->get('content');
            $lecture->status = $request->get('status');
            $lecture->save();

            if ($lecture) {
                return redirect()->route('modul.show', $slug)->with('success', 'Data berhasil diubah');
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
    public function destroy($slug, $urutan)
    {
        $modul_id = Modul::where('slug', $slug)->value('id');
        $lecture = Lecture::where('modul_id', $modul_id)->where('urutan', $urutan)->first();
        $lecture->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function status(Request $request) {
        $lecture = Lecture::where('id', $request->get('id'))->first();
        $lecture->status = $request->get('status');
        $lecture->save();
        if($lecture->status == '0') {
            $status = 'Data berhasil disembunyikan';
        }
        else {
            $status = 'Data berhasil dipublikasikan';
        }
        if ($lecture) {
            return redirect()->back()->with('success', $status);
        } else {
            return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
        }
    }
}
