<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $grade = Grade::all();
        $subject = Subject::all();
        $today = Carbon::now("GMT+7")->toDateString();
        $check = Attendance::where('user_id', $user->id)->whereNotNull('start')->whereNull('end')->first(); 

        return view('admin.dashboard.index', compact('user','grade','subject','today','check'));
    }

    //pake authenticate ambil join buat form untuk absen
}
