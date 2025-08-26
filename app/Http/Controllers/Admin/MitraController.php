<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    public function index()
    {
        $kemitraan = Mitra::when(request()->q, function ($query) {
            $query->where('judul', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        $kemitraan->appends(['q' => request()->q]);

        return inertia('Admin/Kemitraan/Index', [
            'achievements' => $kemitraan,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Kemitraan/Create');
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
            $fotoPath = $request->file('foto')->store('kemitraan', 'public');
        }

        Mitra::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.kemitraan.index');
    }

    public function edit(Mitra $kemitraan)
    {
        return inertia('Admin/Kemitraan/Edit', [
            'kemitraan' => $kemitraan,
        ]);
    }

    public function update(Request $request, Mitra $kemitraan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kemitraan->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        if ($request->hasFile('foto')) {
            if ($kemitraan->foto) {
                Storage::disk('public')->delete($kemitraan->foto);
            }
            $fotoPath = $request->file('foto')->store('kemitraan', 'public');
            $kemitraan->update(['foto' => $fotoPath]);
        }

        return redirect()->route('admin.kemitraan.index')->with('success', 'Kemitraan Berhasil Diperbarui');
    }

    public function destroy(Mitra $kemitraan)
    {
        if ($kemitraan->foto) {
            Storage::disk('public')->delete($kemitraan->foto);
        }

        $kemitraan->delete();

        return redirect()->route('admin.kemitraan.index')->with('success', 'Kemitraan Berhasil Dihapus');
    }

}
