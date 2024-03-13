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
        //excel all
        $attendance = Attendance::with(['user', 'code', 'grade', 'subject'])
            ->orderBy('created_at', 'DESC')
            ->get();

        // Iterate over each attendance record to get the related code and PJ
        $getCode = [];
        $getPJ = [];
        foreach ($attendance as $record) {
            $code = Code::where('id', $record->code_id)->first();
            $getCode[$record->id] = $code; // Store the code in an array with attendance record ID as key

            // Assuming 'user_id' is the foreign key in the Code model that corresponds to the PJ's user ID
            $pj = User::where('id', $code->user_id)->first();
            $getPJ[$record->id] = $pj; // Store the PJ in an array with attendance record ID as key
        }

        return view('admin.attendance.history', compact('attendance', 'getCode', 'getPJ'));
    }


    public function selfIndex()
    {
        //self
        $attendance = Attendance::with(['user', 'code', 'grade', 'subject'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();

        $getCode = [];
        $getPJ = [];

        foreach ($attendance as $record) {
            // Retrieve the code for each attendance record
            $code = Code::where('id', $record->code_id)->first();
            $getCode[$record->id] = $code; // Store the code in an array with attendance record ID as key

            // Assuming 'user_id' is the foreign key in the Code model that corresponds to the PJ's user ID
            $pj = User::where('id', $code->user_id)->first();
            $getPJ[$record->id] = $pj; // Store the PJ in an array with attendance record ID as key
        }

        return view('admin.attendance.index', compact('attendance', 'getCode', 'getPJ'));
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
