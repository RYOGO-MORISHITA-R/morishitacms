<?php
// app/Http/Controllers/TemplateController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = DB::table('templates')
            ->leftJoin('users', 'templates.userId', '=', 'users.id')
            ->leftJoin('csses', 'templates.cssId', '=', 'csses.cssId')
            ->leftJoin('javascripts', 'templates.jsId', '=', 'javascripts.jsId')
            ->select(
                'templates.*',
                'users.name as username',
                'csses.cssName',
                'csses.cssCode',
                'javascripts.jsName',
                'javascripts.jsCode'
            )
            ->orderBy('templates.tmpupdatedatetime', 'desc')
            ->get();

        return view('templatelist', compact('templates'));
    }

    public function create()
    {
        $csses = DB::table('csses')->get();
        $javascripts = DB::table('javascripts')->get();
        return view('template_create', compact('csses', 'javascripts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tmpcode' => 'required|string|max:255',
            'tmpname' => 'required|string|max:255',
            'tmphtml' => 'required',
        ]);

        DB::table('templates')->insert([
            'tmpcode' => $request->tmpcode,
            'tmpname' => $request->tmpname,
            'tmphtml' => $request->tmphtml,
            'userId' => Auth::id(),
            'cssId' => $request->cssId,
            'jsId' => $request->jsId,
            'tmpcreatedatetime' => now(),
            'tmpupdatedatetime' => now(),
        ]);

        return redirect()->route('templatelist')->with('success', 'テンプレートを作成しました');
    }
}

