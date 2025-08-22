<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $articles = Article::all();
        return view('admin.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' =>'required|string|max:255',
            'content' =>'required|string',
        ]);

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('admin.index')->with('success', 'Article created successfully');
    }

    public function edit($id)
    {
        $article = Article::find($id);
        $categories = Category::all();

        return view('admin.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' =>'required|string|max:255',
        'content' =>'required|string',
    ]);

    $article = Article::find($id);
    if (!$article) {
        return redirect()->route('admin.index')->with('error', 'Article not found');
    }

    $article->title = $request->title;
    $article->content = $request->content;
    $article->category_id = $request->category_id;
    $article->save();

    return redirect()->route('admin.index')->with('success', 'Article updated successfully');
}

    public function show($id)
    {
        $article = Article::find($id);
        return view('admin.show', compact('article'));
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return redirect()->route('admin.index')->with('success', 'Article deleted successfully');
    }

    public function user()
    {
        
    }
}
    