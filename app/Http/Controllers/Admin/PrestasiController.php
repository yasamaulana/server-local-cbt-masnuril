<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PrestasiImport;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::when(request()->q, function ($prestasi) {
            $prestasi = $prestasi->where('judul', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        $prestasi->appends(['q' => request()->q]);

        return inertia('Admin/Prestasi/Index', [
            'achievements' => $prestasi,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Prestasi/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('prestasi', 'public');
        }

        Prestasi::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.prestasi.index');
    }

    public function edit(Prestasi $prestasi)
    {
        return inertia('Admin/Prestasi/Edit', [
            'prestasi' => $prestasi,
        ]);
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $prestasi->judul = $request->judul;
        $prestasi->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto')) {
            if ($prestasi->foto) {
                Storage::delete($prestasi->foto);
            }
            $prestasi->foto = $request->file('foto')->store('prestasi', 'public');
        }

        $prestasi->save();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi Berhasil Diperbarui');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->foto) {
            Storage::delete($prestasi->foto);
        }

        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi Berhasil Dihapus');
    }

    public function import()
    {
        return inertia('Admin/Prestasi/Import');
    }

    public function storeImport(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new PrestasiImport(), $request->file('file'));

        return redirect()->route('admin.prestasi.index');
    }
}
