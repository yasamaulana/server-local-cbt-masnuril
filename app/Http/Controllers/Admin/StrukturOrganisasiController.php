<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $strukturs = StrukturOrganisasi::when(request()->q, function ($query) {
            $query->where('judul', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        $strukturs->appends(['q' => request()->q]);

        return inertia('Admin/StrukturOrganisasi/Index', [
            'strukturs' => $strukturs,
        ]);
    }

    public function create()
    {
        return inertia('Admin/StrukturOrganisasi/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('StrukturOrganisasi', 'public');
        }

        StrukturOrganisasi::create([
            'judul' => $validated['judul'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.struktur-organisasi.index');
    }

    public function edit(StrukturOrganisasi $strukturOrganisasi)
    {
        return inertia('Admin/StrukturOrganisasi/Edit', [
            'struktur' => $strukturOrganisasi,
        ]);
    }

    public function update(Request $request, StrukturOrganisasi $strukturOrganisasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $strukturOrganisasi->judul = $request->judul;

        if ($request->hasFile('foto')) {
            if ($strukturOrganisasi->foto) {
                Storage::delete($strukturOrganisasi->foto);
            }
            $strukturOrganisasi->foto = $request->file('foto')->store('StrukturOrganisasi', 'public');
        }

        $strukturOrganisasi->save();

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Organisasi Berhasil Diperbarui');
    }

    public function destroy(StrukturOrganisasi $strukturOrganisasi)
    {
        if ($strukturOrganisasi->foto) {
            Storage::delete($strukturOrganisasi->foto);
        }

        $strukturOrganisasi->delete();

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Organisasi Berhasil Dihapus');
    }

}
