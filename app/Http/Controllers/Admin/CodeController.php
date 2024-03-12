<?php

namespace App\Http\Controllers\Admin;

use App\Models\Code;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    public function index()
    {
        $kode = Code::orderBy('created_at', 'DESC')
            ->with('user')
            ->whereHas('user', function ($query) {
                $query->where('id', auth()->id());
            })
            ->get();

        return view('admin.code.index', compact('kode'));
    }


    public function store()
    {
        $code = Str::random(10);
        Code::create([
            'user_id' => Auth::id(),
            'code' => $code,
        ]);

        return redirect()->back()->with('code', $code);
    }
}
