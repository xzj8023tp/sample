<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $params = $this->validate($request,[
            'content'   => 'required|max:140',
        ]);
        Auth::user()->statuses()->create([
            'content'  =>$params['content'],//动态内容
        ]);
        return redirect()->back();
    }
}
