<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\keterserapanImport;
use App\Models\Keterserapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KeterserapanController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $keterserapan = Keterserapan::when(request()->q, function ($query) {
            $query->where('program_keahlian', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        $keterserapan->appends(['q' => request()->q]);

        return inertia('Admin/Keterserapan/Index', [
            'keterserapan' => $keterserapan,
        ]);
    }

    // Show the form for creating a new resource
    public function create()
    {
        return inertia('Admin/Keterserapan/Create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_keahlian' => 'required|string|max:255',
            'jumlah_laki_laki' => 'required|integer|max:60',
            'jumlah_perempuan' => 'required|integer|max:60',
            'bekerja' => 'required|integer|max:60',
            'kuliah' => 'required|integer|max:60',
            'usaha' => 'required|integer|max:60',
        ]);

        $jumlah = $validated['jumlah_laki_laki'] + $validated['jumlah_perempuan'];

        Keterserapan::create([
            'program_keahlian' => $validated['program_keahlian'],
            'jumlah_laki_laki' => $validated['jumlah_laki_laki'],
            'jumlah_perempuan' => $validated['jumlah_perempuan'],
            'bekerja' => $validated['bekerja'],
            'kuliah' => $validated['kuliah'],
            'usaha' => $validated['usaha'],
            'jumlah' => $jumlah,
        ]);

        return redirect()->route('admin.keterserapan.index')->with('success', 'Keterserapan Berhasil Ditambahkan');
    }

    // Show the form for editing the specified resource
    public function edit(Keterserapan $keterserapan)
    {
        return inertia('Admin/Keterserapan/Edit', [
            'keterserapan' => $keterserapan,
        ]);
    }

    // Update the specified resource in storage
    public function update(Request $request, Keterserapan $keterserapan)
    {
        $validated = $request->validate([
            'program_keahlian' => 'required|string|max:255',
            'jumlah_laki_laki' => 'required|integer|max:60',
            'jumlah_perempuan' => 'required|integer|max:60',
            'bekerja' => 'required|integer|max:60',
            'kuliah' => 'required|integer|max:60',
            'usaha' => 'required|integer|max:60',
        ]);

        $jumlah = $validated['jumlah_laki_laki'] + $validated['jumlah_perempuan'];

        $keterserapan->update([
            'program_keahlian' => $validated['program_keahlian'],
            'jumlah_laki_laki' => $validated['jumlah_laki_laki'],
            'jumlah_perempuan' => $validated['jumlah_perempuan'],
            'bekerja' => $validated['bekerja'],
            'kuliah' => $validated['kuliah'],
            'usaha' => $validated['usaha'],
            'jumlah' => $jumlah,
        ]);

        return redirect()->route('admin.keterserapan.index')->with('success', 'Keterserapan Berhasil Diperbarui');
    }

    // Remove the specified resource from storage
    public function destroy(Keterserapan $keterserapan)
    {
        $keterserapan->delete();

        return redirect()->route('admin.keterserapan.index')->with('success', 'Keterserapan Berhasil Dihapus');
    }

    // Show the form for importing resources
    public function import()
    {
        return inertia('Admin/Keterserapan/Import');
    }

    // Store imported resources
    public function storeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new keterserapanImport(), $request->file('file'));

        return redirect()->route('admin.keterserapan.index')->with('success', 'Data Berhasil Diimpor');
    }
}
