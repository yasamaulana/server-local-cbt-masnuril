<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AbsenceTeacher;
use App\Models\Scedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function __invoke()
    {
        $class = Auth::guard('student')->user()->classroom->id;
        $day = \Carbon\Carbon::now()->locale('id');
        $day->settings(['formatFunction' => 'translatedFormat']);
        $current_time = now()->format('H:i:s');
        $theacher = Scedule::where('day', $day->format('l'))
            ->where('class_id', $class)
            ->whereTime('start_time', '<=', $current_time)
            ->whereTime('end_time', '>=', $current_time)
            ->with(['teacher', 'lesson', 'class'])
            ->first();
        return inertia('Student/Presence/Teacher', [
            'teacher' => $theacher,
        ]);
    }

    public function teacherPresence(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|numeric',
            'lesson_id' => 'required|numeric',
            'class_id' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        AbsenceTeacher::create([
            'teacher_id' => $request->teacher_id,
            'lesson_id' => $request->lesson_id,
            'class_id' => $request->class_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Absensi berhasil']);
    }

    public function checkAbsensiTodayTeacher()
    {
        //get teacher scedule
        $class = Auth::guard('student')->user()->classroom->id;
        $day = \Carbon\Carbon::now()->locale('id');
        $day->settings(['formatFunction' => 'translatedFormat']);
        $current_time = now()->format('H:i:s');
        $teacher = Scedule::where('day', $day->format('l'))
            ->where('class_id', $class)
            ->whereTime('start_time', '<=', $current_time)
            ->whereTime('end_time', '>=', $current_time)
            ->first();

        // Cek apakah ada entri absensi untuk siswa ini pada hari ini
        $hasAbsensiToday = AbsenceTeacher::where('class_id', $teacher->class_id)
            ->where('teacher_id', $teacher->teacher_id)
            ->where('lesson_id', $teacher->lesson_id)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        return response()->json(['hasAbsensiToday' => $hasAbsensiToday]);
    }
}
