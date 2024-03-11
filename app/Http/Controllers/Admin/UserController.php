<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.user.index',['users' => $users]);
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(Request $request){
        $data = $request->except('_token');
        
        $request->validate([
            'assistant_id' => 'required',
            'role'=> 'required',
            'name'=> 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $isEmailExist = User::where('email', $request->email)->exists();

        if ($isEmailExist) {
            return back()->withErrors([
                'email' => 'Email ini sudah digunakan!'
            ])->withInput();
        }
        
        $data['password'] = Hash::make($request->password);
        $data['join_date'] = Carbon::now()->format('Y-m-d');

        User::create($data);
        return redirect()->route('admin.user')->with('success', 'Asisten abru berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $decryptId = Crypt::decryptString($id);
        $user = User::find($decryptId);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(Request $request,string $id)
    {
        $data = $request->except('_token');
        $request->validate([
            'assistant_id' => 'required',
            'role'=> 'required',
            'name'=> 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::find($id);

        $data['password'] = Hash::make($request->password);
        
        $user->update($data);
        return redirect()->route('admin.user')->with('success', 'Berhasil memperbarui data pengguna');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        // $hasActiveLoans = $user->whereHas('loan', function ($q) {
        //     $q->where('is_returned', 0);
        // })->exists();

        // if ($hasActiveLoans) {
        //     return redirect()->route('admin.user')->with('error', 'Gagal menghapus akun pengguna, karena pengguna masih memiliki pinjaman aktif !');
        // }

        $user->delete();
        
        return redirect()->route('admin.user')->with('success', 'Berhasil menghapus akun pengguna !');
    }
}
