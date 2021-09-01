<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;
use Auth;
use DB;

/* IMPORT MODEL */
use App\Modul;
use App\Lecture;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modul = Modul::get();
        $arr_lecture = [];
        foreach ($modul as $key) {
            $lecture = Lecture::where('modul_id', $key->id)->where('status', '1')->count();
            $arr_lecture[$key->id] = $lecture;
        }
        return view('func.lihatModul', compact('modul', 'arr_lecture'))->with('title', 'Modul');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('func.tambahModul')->with('title', 'Add Modul');
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
            'level' => ['required', 'string', 'max:255', Rule::notIn(['', '0'])],
            'platform' => ['required', 'string', 'max:255'],
            'image' => ['image'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan, silahkan koreksi.');
        } else {
            $modul = new Modul();
            $modul->user_id = Auth::user()->id;
            $modul->title = $request->get('title');
            $modul->desc = $request->get('desc');
            $modul->level = $request->get('level');
            $modul->platform = $request->get('platform');
            $modul->slug = Str::slug($request->get('title'));
            $uploadedFile = $request->file('image');

            if ($uploadedFile) {
                $ext = $uploadedFile->getClientOriginalExtension();
                $path = 'public/uploads/modul/' . Str::slug($request->get('title'));
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }
                $storing = $uploadedFile->storeAs($path, Str::slug($request->get('title')) . '.' . $ext);
                $modul->image = $storing;
            }

            if ($request->get('status') == '') {
                $modul->status = '0';
            } else {
                $modul->status = $request->get('status');
            }
            $modul->save();

            return redirect()->route('modul.index')->with('success', 'Data berhasil ditambah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $modul = Modul::where('slug', $slug)->first();
        $lecture = Lecture::where('modul_id', $modul->id)->where('status', '1')->count();
        return view('func.showModul', compact('modul', 'lecture'))->with('title', $modul->title);
    }

    /* ajax get description */

    public function desc($slug)
    {
        $modul = Modul::where('slug', $slug)->first();
        $lecture = Lecture::where('modul_id', $modul->id)->where('status', '1')->count();
        return view('func.showModul', compact('modul', 'lecture'))->with('title', $modul->title);
    }

    public function ajax_desc($slug)
    {
        $modul = Modul::where('slug', $slug)->first();
        $lecture = Lecture::where('modul_id', $modul->id)->where('status', '1')->count();
        return view('func.ajaxModulDesc', compact('modul', 'lecture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $modul = Modul::where('slug', $slug)->first();
        return view('func.editModul', compact('modul', 'slug'))->with('title', 'Edit Modul');
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

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255', Rule::notIn(['', '0'])],
            'desc' => ['required', 'string'],
            'image' => ['image'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Terjadi kesalahan input, silahkan coba lagi.');
        } else {
            $modul = Modul::find($id);
            $split_image = preg_split('/\//', $modul->image, 0, 0);
            $old_image = array_pop($split_image);
            $old_slug = $modul->slug;
            $uploadedFile = $request->file('image');
            $modul->title = $request->get('title');
            $modul->level = $request->get('level');
            $modul->desc = $request->get('desc');
            $modul->slug = Str::slug($request->get('title'));

            if (Str::slug($request->get('title')) != $old_slug && !$uploadedFile) {
                $old_path = 'public/uploads/modul/' . $old_slug;
                $path = 'public/uploads/modul/' . Str::slug($request->get('title'));
                if (Storage::exists($old_path)) {
                    Storage::rename($old_path, $path);
                }
                $modul->image = $path . '/' . $old_image;
            } elseif ((Str::slug($request->get('title')) != $old_slug && $uploadedFile) || (Str::slug($request->get('title')) == $old_slug && $uploadedFile)) {
                $ext = $uploadedFile->getClientOriginalExtension();
                $old_path = 'public/uploads/modul/' . $old_slug;
                $path = 'public/uploads/modul/' . Str::slug($request->get('title'));
                if (Storage::exists($old_path)) {
                    Storage::deleteDirectory($old_path);
                }
                if (Storage::exists($path)) {
                    Storage::deleteDirectory($path);
                }
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }
                $storing = $uploadedFile->storeAs($path, Str::slug($request->get('title')) . '.' . $ext);
                $modul->image = $storing;
            }

            $modul->status = $request->get('status');
            $modul->save();

            if ($modul) {
                return redirect()->route('modul.index')->with('success', 'Data berhasil diubah');
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
    public function destroy($id)
    {
        $modul = Modul::find($id);
        $path = 'public/uploads/modul/' . $modul->slug;
        Storage::deleteDirectory($path);
        $modul->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function status(Request $request)
    {
        $modul = Modul::where('id', $request->get('id'))->first();
        $modul->status = $request->get('status');
        $modul->save();
        if ($modul->status == '0') {
            $status = 'Data berhasil disembunyikan';
        } else {
            $status = 'Data berhasil dipublikasikan';
        }
        if ($modul) {
            return redirect()->back()->with('success', $status);
        } else {
            return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
        }
    }
}
