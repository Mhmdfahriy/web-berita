<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|integer',
            'comment' => 'required|string',
            'comment_id' => 'nullable|exists:comments,id',
        ]);
    
        $commentData = [
            'user_id' => Auth::id(),
            'article_id' => $request->article_id,
            'comment' => $request->comment,
        ];
    
        if ($request->has('comment_id')) {
            $commentData['parent_id'] = $request->comment_id;
        }
    
        $comment = Comment::create($commentData);
    
        if ($comment) {
            return redirect()->back()->with('status', 'Comment Successfully Added');
        }
        return redirect()->back()->with('status', 'Comment Failed to Add');
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment && $comment->delete()) {
            return redirect()->back()->with('status', 'Delete Comment Successfully ');
        }
        return redirect()->back()->with('status', 'Delete Comment Failed ');
    }

    
}
