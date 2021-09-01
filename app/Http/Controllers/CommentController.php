<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Post;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $posting_id) {
        if($request->get('content') == '') {
            return redirect()->back();
        }
        else {
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $posting_id;
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
        $comment = Comment::find($comment_id);
        $comment->delete();

        if($comment) {
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }
        else {
            return redirect()->back()->with('failure', 'Gagal menghapus komentar silahkan coba lagi.');
        }
    }
}
