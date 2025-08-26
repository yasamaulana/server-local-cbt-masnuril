<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendaftarExport;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PPDBController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query();

        // Filter pencarian keyword
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('nisn', 'like', '%' . $request->q . '%')
                    ->orWhere('nik', 'like', '%' . $request->q . '%');
            });
        }

        // Filter status (default: Menunggu Konfirmasi)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        // Filter tahun (default: tahun ini)
        $tahun = $request->tahun ?? now()->year;
        $query->whereYear('created_at', $tahun);

        $pendaftarans = $query->latest()->paginate(10)->withQueryString();

        return inertia('Admin/PPDB/Index', [
            'pendaftarans' => $pendaftarans,
        ]);
    }


    public function show($id)
    {
        //get pendaftaran by id
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pendaftaran->kk = $pendaftaran->kk ? asset('storage/' . $pendaftaran->kk) : null;
        $pendaftaran->ktp_ayah = $pendaftaran->ktp_ayah ? asset('storage/' . $pendaftaran->ktp_ayah) : null;
        $pendaftaran->ktp_ibu = $pendaftaran->ktp_ibu ? asset('storage/' . $pendaftaran->ktp_ibu) : null;
        $pendaftaran->ijazah = $pendaftaran->ijazah ? asset('storage/' . $pendaftaran->ijazah) : null;
        $pendaftaran->kip = $pendaftaran->kip ? asset('storage/' . $pendaftaran->kip) : null;
        $pendaftaran->kks = $pendaftaran->kks ? asset('storage/' . $pendaftaran->kks) : null;

        //render with inertia
        return inertia('Admin/PPDB/Show', [
            'pendaftaran' => $pendaftaran,
        ]);
    }
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'student_id' => 'required|array',
            'status' => 'required|in:Menunggu Verifikasi,Diterima,Ditolak',
        ]);

        //insert to student table when status is Diterima
        if ($request->status === 'Diterima') {
            foreach ($request->student_id as $id) {
                $pendaftaran = Pendaftaran::find($id);
                if ($pendaftaran) {
                    Student::create([
                        'classroom_id' => 1,
                        'school_id' => 1,
                        'nisn' => $pendaftaran->nisn,
                        'nik' => $pendaftaran->nik,
                        'name' => $pendaftaran->nama,
                        'ketua_kelas' => 1,
                        'password' => 'manuril' . $pendaftaran->nisn,
                    ]);
                }
            }
        }

        if ($request->status === 'Ditolak') {
            //if already exists in student table, delete it
            Student::whereIn('nisn', function ($query) use ($request) {
                $query->select('nisn')
                    ->from('pendaftarans')
                    ->whereIn('id', $request->student_id);
            })->delete();
        }

        Pendaftaran::whereIn('id', $request->student_id)
            ->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function export()
    {
        return Excel::download(new PendaftarExport, 'pendaftaran_siswa.xlsx');
    }
}
