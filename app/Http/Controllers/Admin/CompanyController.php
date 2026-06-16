<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query()->orderBy('name');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }
        
        // Count active internship applications for each company
        $companies = $query->withCount([
            'internshipApplications as active_internships' => fn($q) =>
                $q->where('status', 'approved')
        ])->paginate(15);
        
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:50',
            'address'        => 'required|string',
            'website'        => 'nullable|url|max:255',
            'contact_person' => 'required|string|max:255',
        ], [
            'name.required'           => 'Nama perusahaan wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
            'phone.required'          => 'Nomor telepon wajib diisi.',
            'address.required'        => 'Alamat wajib diisi.',
            'website.url'             => 'Format URL website tidak valid.',
            'contact_person.required' => 'Nama contact person wajib diisi.',
        ]);

        Company::create($request->only([
            'name', 'email', 'phone', 'address', 'website', 'contact_person',
        ]));

        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function show(Company $company)
    {
        $company->load(['internshipApplications' => function($query) {
            $query->latest()->with('user');
        }]);
        
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:50',
            'address'        => 'required|string',
            'website'        => 'nullable|url|max:255',
            'contact_person' => 'required|string|max:255',
        ], [
            'name.required'           => 'Nama perusahaan wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
            'phone.required'          => 'Nomor telepon wajib diisi.',
            'address.required'        => 'Alamat wajib diisi.',
            'website.url'             => 'Format URL website tidak valid.',
            'contact_person.required' => 'Nama contact person wajib diisi.',
        ]);

        $company->update($request->only([
            'name', 'email', 'phone', 'address', 'website', 'contact_person',
        ]));

        return redirect()->route('admin.companies.index')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $company)
    {
        if ($company->internshipApplications()->exists()) {
            return redirect()->route('admin.companies.index')->with('error', 'Tidak dapat menghapus perusahaan karena masih memiliki data pengajuan magang.');
        }

        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
