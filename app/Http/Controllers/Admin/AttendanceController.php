<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Code;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::with(['user', 'grade', 'subject', 'code'])
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('admin.attendance.index', compact('attendance')); 
    }

    public function selfIndex()
    {
        $userId = Auth::id();

        $attendance = Attendance::with(['user', 'grade', 'subject', 'code']) 
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.attendance.history', compact('attendance')); 
    }

    public function clockIn(Request $request)
    {
        // Validation
        $request->validate([
            'assistant_id' => 'required',
            'code' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required',
            'teaching_role' => 'required',
        ]);

        $idLogin = Auth::id();

        $getIdAsisten = $request->assistant_id;
        $getCode = $request->code;

        $user = User::where('assistant_id', $getIdAsisten)->first();

        if (!$user || $user->id !== $idLogin) {
            return redirect()->back()->with('error', 'Invalid user');
        }

        $code = Code::where('code', $getCode)->whereNull('get_user_id')->first();

        if (!$code) {
            return redirect()->back()->with('error', 'Invalid code');
        }

        if ($code->user_id === $idLogin) {
            return redirect()->back()->with('error', 'Code already used by the same user');
        }

        // Create attendance 
        $attendance = new Attendance();
        $attendance->grade_id = $request->grade_id;
        $attendance->subject_id = $request->subject_id;
        $attendance->user_id = $idLogin;
        $attendance->teaching_role = $request->teaching_role;
        $attendance->date = now()->toDateString();
        $carbon = Carbon::now('GMT+7');
        $attendance->start = $carbon->toTimeString();
        $attendance->code_id = $code->id;
        $attendance->save();

        // Update the code to mark it used by other user
        $code->get_user_id = $idLogin;
        $code->save();

        return redirect()->back()->with('success', 'Attendance success');
    }



    public function clockOut(Request $request)
    {
        $carbon = Carbon::now('GMT+7');
        $today = $carbon->toDateString();
        $idLogin = Auth::id();

        // Retrieve active attendance record for the logged in user on the current date
        $checkAttendance = Attendance::where('user_id', $idLogin)
            ->where('date', $today)
            ->whereNull('end')
            ->first();

        if (!$checkAttendance) {
            return redirect()->back()->with('error', "No active attendance record found");
        }

        // Update attendance record with clock-out time and duration
        $start = $checkAttendance->start;
        $end = $carbon->toTimeString();
        $checkAttendance->end = $end;
        $hasil = $carbon->diffInMinutes($start);
        $checkAttendance->duration = $hasil;
        $checkAttendance->save();

        return redirect()->back()->with('success', 'Clock-out success');
    }
}
