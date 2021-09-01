<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* import classes */
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Post;
use App\Session;
use App\Kelas;

class PostingController extends Controller
{
    public function store(Request $request, $id, $session_of) {
        $messages = [
            'required' => 'Field tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else {
            $kelas = Kelas::find($id);
            $session = Session::where('kelas_id', $kelas->id)->where('session_of', $session_of)->first();

            $posting = new Post();
            $posting->user_id = Auth::user()->id;
            $posting->session_id = $session->id;
            $posting->content = $request->get('content');
            $posting->save();

            if ($posting) {
                return redirect()->back()->with('success', 'Udah di post.');
            }
            else {
                return redirect()->back()->with('failure', 'Terjadi kesalahan pada server, silahkan coba lagi.');
            }
        }
    }

    public function destroy($id) {
        $posting = Post::find($id);
        $posting->delete();

        return redirect()->back()->with('success', 'Posting berhasil dihapus.');
    }
}
