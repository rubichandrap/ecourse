<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;

use App\Session;
use App\Absent;
use App\Tugas;
use App\Kelas;
use App\TugasComment;

class TugasController extends Controller
{
    public function index($kelas_id, $session_of) {
        $kelas = Kelas::find($kelas_id);
        $session = Session::where('kelas_id', $kelas_id)->where('session_of', $session_of)->first();
        $all_session = Session::where('kelas_id', $kelas_id)->get();
        $tugas = Tugas::with('user')->where('session_id', $session->id)->latest()->get();
        $tugas_comments = TugasComment::with('user')->whereHas('tugas', function($q) use ($session){
            $q->where('tugas.session_id', $session->id);
        })->latest()->get();
        return view('func.showSession', compact('kelas', 'session', 'all_session', 'tugas', 'tugas_comments'))->with('title', 'Show Tugas');
    }

    public function store(Request $request, $kelas_id, $session_of) {
        
        $messages = [
            'required' => 'Field tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
            'file' => ['file', 'mimes:docx,doc,xls,jpg,jpeg,png,txt', 'max:2048'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('failure', 'Cek kembali input kamu.');
        }
        else {
            $kelas_title = Kelas::where('id', $kelas_id)->value('title');
            $session = Session::where('kelas_id', $kelas_id)->where('session_of', $session_of)->first();
            $uploadedFile = $request->file('file');
            $tugas = new Tugas();
            $tugas->user_id = Auth::user()->id;
            $tugas->session_id = $session->id;
            $tugas->content = $request->get('content');
            if($uploadedFile) {
                $tugas_count = Tugas::where('user_id', Auth::user()->id)->where('session_id', $session->id)->count();
                $increment = intval($tugas_count + 1);
                $ext = $uploadedFile->getClientOriginalExtension();
                $path = 'public/uploads/kelas/'.Str::slug($kelas_title).'/'.Str::slug($session->title);
                $storing = $uploadedFile->storeAs($path, Auth::user()->nbm_nim . '-' . $increment . '.' . $ext);
                $tugas->file = $storing;
            }
            else {
                $tugas->file = '';
            }
            $tugas->save();
            if($tugas) {
                return redirect()->back()->with('success', 'Tugas kamu berhasil di posting.');
            }
            else {
                return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
            }
        }
    }

    public function destroy($id) {
        $tugas = Tugas::find($id);

        Storage::delete($tugas->file);
        $tugas->delete();
        
        if($tugas) {
            return redirect()->back()->with('success', 'Posting berhasil dihapus.');
        }
        else {
            return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
        }
    }
}
