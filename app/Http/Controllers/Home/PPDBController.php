<?php

namespace App\Http\Controllers\Home;

use App\Exports\PendaftarExport;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PPDBController extends Controller
{
    public function index()
    {
        return view('pages.ppdb.pendaftaran');
    }

    public function simpanDataSiswa(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'nisn' => 'required|digits_between:8,10',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'asal_sekolah' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'nama_ayah' => 'required|string',
            'alamat_ayah' => 'required|string',
            'nik_ayah' => 'required|digits:16',
            'pekerjaan_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'alamat_ibu' => 'required|string',
            'nik_ibu' => 'required|digits:16',
            'pekerjaan_ibu' => 'required|string',
            'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ayah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ibu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kks' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'rekomendasi' => 'nullable|string',
        ]);

        // Simpan file
        $validated['kk'] = $request->file('kk')->store('pendaftaran/kk', 'public');
        $validated['ktp_ayah'] = $request->file('ktp_ayah')->store('pendaftaran/ktp_ayah', 'public');
        $validated['ktp_ibu'] = $request->file('ktp_ibu')->store('pendaftaran/ktp_ibu', 'public');
        $validated['ijazah'] = $request->file('ijazah')->store('pendaftaran/ijazah', 'public');

        if ($request->hasFile('kip')) {
            $validated['kip'] = $request->file('kip')->store('pendaftaran/kip', 'public');
        }

        if ($request->hasFile('kks')) {
            $validated['kks'] = $request->file('kks')->store('pendaftaran/kks', 'public');
        }

        Pendaftaran::create($validated);

        return redirect()->route('pendaftaran.berhasil')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function berhasilMendaftar()
    {
        return view('pages.ppdb.berhasil-mendaftar');
    }

    public function statusPendaftaran()
    {
        return view('pages.ppdb.status-pendaftaran');
    }

    public function cekHasilPendaftaran(Request $request)
    {
        $nisn = $request->query('nisn');

        if (!$nisn) {
            return response()->json([
                'success' => false,
                'message' => 'NISN harus diisi.',
            ]);
        }

        $data = Pendaftaran::where('nisn', $nisn)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => "Data dengan NISN $nisn tidak ditemukan.",
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
