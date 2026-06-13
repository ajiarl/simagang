<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'internshipApplication.company', 'verifier']);

        if ($request->filled('month')) {
            $query->whereMonth('date', date('m', strtotime($request->month)))
                  ->whereYear('date', date('Y', strtotime($request->month)));
        }

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('verified_at');
            } else if ($request->status === 'pending') {
                $query->whereNull('verified_at');
            }
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(20);

        return view('admin.attendances.index', compact('attendances'));
    }
}
