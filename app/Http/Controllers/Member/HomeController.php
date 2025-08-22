<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('member.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::with(['comments.replies.user', 'comments.user'])
                          ->findOrFail($id);
        return view('member.show', compact('article'));
    }
}
