<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $query = User::role('mahasiswa')->orderBy('name');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $students = $query->withCount([
            'internshipApplications as active_internship' => fn($q) =>
                $q->where('status', 'approved')
        ]);

        // Filter by internship status
        if ($request->status === 'active') {
            $students->having('active_internship', '>', 0);
        } elseif ($request->status === 'inactive') {
            $students->having('active_internship', '=', 0);
        }

        $students = $students->paginate(15);
        
        return view('admin.students.index', compact('students'));
    }

    /**
     * Display the specified student.
     */
    public function show(User $student)
    {
        // Pastikan user adalah mahasiswa
        if (!$student->hasRole('mahasiswa')) {
            abort(404);
        }
        
        $student->load(['internshipApplications.company', 'internshipApplications.internshipPeriod']);
        
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        if (!$student->hasRole('mahasiswa')) {
            abort(404);
        }
        
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        if (!$student->hasRole('mahasiswa')) {
            abort(404);
        }
        
        $request->validate([
            'name'     => 'required|string|max:255',
            'nim'      => 'nullable|string|max:50',
            'email'    => 'required|email|unique:users,email,' . $student->id,
            'phone'    => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah digunakan oleh akun lain.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $student->update($request->only([
            'name', 'nim', 'email', 'phone'
        ]));

        if ($request->filled('password')) {
            $student->update(['password' => \Hash::make($request->password)]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
}
