<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
	public function store(Request $request) {
    	// validacija
        $comment = new Comment();
        $rules = Comment::STORE_RULES;
        $request->validate($rules);
        // novi podaci
        $comment->text = $request->input('text');
        // // samo za testiranje:
        // $comment->author_id = 1;
        $comment->save();
        return $comment;
    }
    public function destroy($id) {
    	$comment = Comment::find($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted'], 200);
    }
}
