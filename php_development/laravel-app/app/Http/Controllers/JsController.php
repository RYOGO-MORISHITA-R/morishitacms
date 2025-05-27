<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JsController extends Controller
{
    // 一覧表示
    public function index()
    {
        $javascripts = DB::table('javascripts')
            ->leftJoin('users', 'javascripts.userId', '=', 'users.id')
            ->select('javascripts.*', 'users.name as username')
            ->orderBy('javascripts.jsUpdatedAt', 'desc')
            ->get();

        return view('jslist', compact('javascripts'));
    }

    // 新規作成フォーム表示
    public function create()
    {
        return view('js_create');
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'jsName' => 'required|string|max:255',
            'jsCode' => 'required|string',
        ]);

        DB::table('javascripts')->insert([
            'jsName' => $request->input('jsName'),
            'jsCode' => $request->input('jsCode'),
            'jsContent' => $request->input('jsContent'),
            'userId' => Auth::id(),
            'jsCreatedAt' => now(),
            'jsUpdatedAt' => now(),
        ]);

        return redirect()->route('jslist')->with('success', 'JavaScriptを登録しました。');
    }
}
