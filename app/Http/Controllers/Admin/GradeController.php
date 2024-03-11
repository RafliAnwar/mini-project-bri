<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();

        return view('admin.grade.index',['grades'=> $grades]);
    }

    public function create()
    {
        return view('admin.grade.create');
    }

    public function edit($id)
    {

        $decryptId = Crypt::decryptString($id);

        $grade = Grade::find($decryptId);

        return view('admin.grade.edit',['grade'=> $grade]);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        $request->validate([
            'class_name' => 'required|string',
            'grade' => 'required|string',
            'faculty' => 'required|string',
            'department' => 'required|string',
        ]);

        Grade::create($data);
        return redirect()->route('admin.grade')->with('success', 'Kelas berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'class_name' => 'required|string',
            'grade' => 'required|string',
            'faculty' => 'required|string',
            'department' => 'required|string',
        ]);

        $grade = Grade::find($id);

        $grade->update($data);
        return redirect()->route('admin.grade')->with('success', 'Sukses memperbarui kelas');

    }

    public function destroy($id)
    {
        $grade =  Grade::find($id);

        $hasActiveItem = Attendance::where('grade_id', $grade->id)->exists();

        if($hasActiveItem){
            return redirect()->route('admin.grade')
            ->with('error', 'Gagal menghapus kelas. Pastikan tidak ada kelas yang terkait dengan absensi yang akan dihapus');
        }

        $grade->forceDelete();
        return redirect()->route('admin.grade')->with('success', 'Kelas berhasil dihapus');
    }
}
