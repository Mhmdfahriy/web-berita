<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // pastikan user login
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->roles->first(); // ambil role pertama jika ada

        if ($role && $role->name === 'Admin') {
            return redirect()->route('admin.index');
        }

        // Jika Member atau belum ada role, redirect ke member dashboard
        return redirect()->route('member.index');
    }

    /**
     * Tampilkan detail artikel untuk member
     */
    public function show($id)
    {
        // Ambil artikel + komentar + replies
        $article = \App\Models\Article::with(['comments.replies.user', 'comments.user'])
                          ->findOrFail($id);

        return view('member.show', compact('article'));
    }
}
