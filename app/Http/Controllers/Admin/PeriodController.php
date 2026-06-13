<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipPeriod;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $activePeriod = InternshipPeriod::active()->first();
        $periods = InternshipPeriod::orderBy('start_date', 'desc')->get();
        
        return view('admin.periods.index', compact('periods', 'activePeriod'));
    }

    public function create()
    {
        return view('admin.periods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'registration_start' => 'required|date',
            'registration_end'   => 'required|date|after_or_equal:registration_start',
            'start_date'         => 'required|date|after_or_equal:registration_end',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'is_active'          => 'boolean',
        ], [
            'name.required'                    => 'Nama periode wajib diisi.',
            'registration_start.required'      => 'Tanggal buka pendaftaran wajib diisi.',
            'registration_start.date'          => 'Format tanggal buka pendaftaran tidak valid.',
            'registration_end.required'        => 'Tanggal tutup pendaftaran wajib diisi.',
            'registration_end.after_or_equal'  => 'Tanggal tutup pendaftaran harus setelah atau sama dengan tanggal buka.',
            'start_date.required'              => 'Tanggal mulai magang wajib diisi.',
            'start_date.after_or_equal'        => 'Tanggal mulai magang harus setelah tanggal tutup pendaftaran.',
            'end_date.required'                => 'Tanggal selesai magang wajib diisi.',
            'end_date.after_or_equal'          => 'Tanggal selesai magang harus setelah tanggal mulai magang.',
        ]);

        $data = $request->only([
            'name', 'registration_start', 'registration_end',
            'start_date', 'end_date',
        ]);
        $data['is_active'] = $request->has('is_active');

        // Business rule: only ONE period can be active at a time
        if ($data['is_active']) {
            InternshipPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        InternshipPeriod::create($data);

        return redirect()->route('admin.periods.index')->with('success', 'Periode magang berhasil dibuat.');
    }

    public function edit(InternshipPeriod $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    public function update(Request $request, InternshipPeriod $period)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'registration_start' => 'required|date',
            'registration_end'   => 'required|date|after_or_equal:registration_start',
            'start_date'         => 'required|date|after_or_equal:registration_end',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'is_active'          => 'boolean',
        ], [
            'name.required'                    => 'Nama periode wajib diisi.',
            'registration_start.required'      => 'Tanggal buka pendaftaran wajib diisi.',
            'registration_start.date'          => 'Format tanggal buka pendaftaran tidak valid.',
            'registration_end.required'        => 'Tanggal tutup pendaftaran wajib diisi.',
            'registration_end.after_or_equal'  => 'Tanggal tutup pendaftaran harus setelah atau sama dengan tanggal buka.',
            'start_date.required'              => 'Tanggal mulai magang wajib diisi.',
            'start_date.after_or_equal'        => 'Tanggal mulai magang harus setelah tanggal tutup pendaftaran.',
            'end_date.required'                => 'Tanggal selesai magang wajib diisi.',
            'end_date.after_or_equal'          => 'Tanggal selesai magang harus setelah tanggal mulai magang.',
        ]);

        $data = $request->only([
            'name', 'registration_start', 'registration_end',
            'start_date', 'end_date',
        ]);
        $data['is_active'] = $request->has('is_active');

        // Business rule: only ONE period can be active at a time
        if ($data['is_active'] && !$period->is_active) {
            InternshipPeriod::where('id', '!=', $period->id)->where('is_active', true)->update(['is_active' => false]);
        }

        $period->update($data);

        return redirect()->route('admin.periods.index')->with('success', 'Periode magang berhasil diperbarui.');
    }
}
