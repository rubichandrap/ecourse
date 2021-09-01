<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Tugas;
use App\TugasComment;

class TugasCommentController extends Controller
{
    public function store(Request $request, $tugas_id) {
        if($request->get('content') == '') {
            return redirect()->back();
        }
        else {
            $comment = new TugasComment();
            $comment->user_id = Auth::user()->id;
            $comment->tugas_id = $tugas_id;
            $comment->content = $request->get('content');
            $comment->save();

            if($comment) {
                return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
            }
            else {
                return redirect()->back()->with('failure', 'Gagal menambahkan komentar, silahkan coba lagi.');
            }
        }
    }

    public function destroy($comment_id) {
        $comment = TugasComment::find($comment_id);
        $comment->delete();

        if($comment) {
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }
        else {
            return redirect()->back()->with('failure', 'Gagal menghapus komentar silahkan coba lagi.');
        }
    }
}
