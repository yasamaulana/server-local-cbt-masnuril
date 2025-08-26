<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AbsenceStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function __invoke()
    {
        return inertia('Student/Presence/Index');
    }

    public function studentPresence(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        AbsenceStudent::create([
            'student_id' => Auth::guard('student')->user()->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Absensi berhasil']);
    }

    public function checkAbsensiTodayStudent(Request $request)
    {
        // Ambil ID siswa dari user yang sedang masuk
        $studentId =  Auth::guard('student')->user()->id;

        // Cek apakah ada entri absensi untuk siswa ini pada hari ini
        $hasAbsensiToday = AbsenceStudent::where('student_id', $studentId)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        return response()->json(['hasAbsensiToday' => $hasAbsensiToday]);
    }
}
