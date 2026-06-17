<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the lecturers.
     */
    public function index(Request $request)
    {
        $query = User::role('dosen')->orderBy('name');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('faculty', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }
        
        $lecturers = $query->paginate(15);
        
        return view('admin.lecturers.index', compact('lecturers'));
    }

    /**
     * Show the form for creating a new lecturer.
     */
    public function create()
    {
        return view('admin.lecturers.create');
    }

    /**
     * Store a newly created lecturer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string|max:50',
            'faculty'    => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'password'   => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $lecturer = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'faculty'    => $request->faculty,
            'department' => $request->department,
            'password'   => $request->password,
        ]);

        $lecturer->assignRole('dosen');

        return redirect()->route('admin.lecturers.index')->with('success', 'Data dosen pembimbing berhasil ditambahkan.');
    }

    /**
     * Display the specified lecturer.
     */
    public function show(User $lecturer)
    {
        if (!$lecturer->hasRole('dosen')) {
            abort(404);
        }
        
        $lecturer->load(['supervisedApplications.internshipPeriod', 'supervisedApplications.user']);
        
        return view('admin.lecturers.show', compact('lecturer'));
    }

    /**
     * Show the form for editing the specified lecturer.
     */
    public function edit(User $lecturer)
    {
        if (!$lecturer->hasRole('dosen')) {
            abort(404);
        }
        
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    /**
     * Update the specified lecturer in storage.
     */
    public function update(Request $request, User $lecturer)
    {
        if (!$lecturer->hasRole('dosen')) {
            abort(404);
        }
        
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $lecturer->id,
            'phone'      => 'nullable|string|max:50',
            'faculty'    => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'password'   => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah digunakan oleh akun lain.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $lecturer->update($request->only([
            'name', 'email', 'phone', 'faculty', 'department'
        ]));

        if ($request->filled('password')) {
            $lecturer->update(['password' => $request->password]);
        }

        return redirect()->route('admin.lecturers.index')->with('success', 'Data dosen pembimbing berhasil diperbarui.');
    }
}
