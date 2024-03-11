<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Crypt;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();

        return view('admin.subject.index',['subjects'=> $subjects]);
    }

    public function create()
    {
        return view('admin.subject.create');
    }

    public function edit($id)
    {

        $decryptId = Crypt::decryptString($id);

        $subject = Subject::find($decryptId);

        return view('admin.subject.edit',['subject'=> $subject]);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        $request->validate([
            'subject_name' => 'required|string'
        ]);

        Subject::create($data);
        return redirect()->route('admin.subject')->with('success', 'Materi berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'subject_name' => 'required|string'
        ]);

        $subject = Subject::find($id);

        $subject->update($data);
        return redirect()->route('admin.subject')->with('success', 'Sukses memperbarui kategori');

    }

    public function destroy($id)
    {
        $subject =  Subject::find($id);

        $hasActiveItem = Attendance::where('subject_id', $subject->id)->exists();

        if($hasActiveItem){
            return redirect()->route('admin.subject')
            ->with('error', 'Gagal menghapus materi. Pastikan tidak ada materi yang terkait dengan absensi yang akan dihapus');
        }

        $subject->forceDelete();
        return redirect()->route('admin.subject')->with('success', 'Materi berhasil dihapus');
    }
}
