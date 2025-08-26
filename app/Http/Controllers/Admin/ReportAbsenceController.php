<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbsenceStudent;
use App\Models\Classroom;
use App\Models\Student;
use Carbon\Carbon;
use App\Exports\AttendanceExport;
use App\Exports\AttendanceTeacherExport;
use App\Models\AbsenceTeacher;
use App\Models\Lesson;
use Maatwebsite\Excel\Facades\Excel;

class ReportAbsenceController extends Controller
{
    public function student(Request $request)
    {
        // Get filters from request, default to current month
        $month = $request->input('month', now()->format('Y-m'));
        $classroomId = $request->input('classroom_id');

        // Fetch classrooms data
        $classrooms = Classroom::all();

        // Fetch students data with optional classroom filter
        $studentsQuery = Student::query();
        if ($classroomId) {
            $studentsQuery->where('classroom_id', $classroomId);
        }
        $students = $studentsQuery->get();

        // Fetch attendance data for the specified month
        $attendance = AbsenceStudent::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->get()
            ->groupBy('student_id');

        // Prepare data for the view
        $attendanceData = $students->map(function ($student) use ($attendance, $month) {
            $daysInMonth = Carbon::parse($month)->daysInMonth;
            $data = [
                'name' => $student->name,
                'attendance' => array_fill(1, $daysInMonth, ''),
            ];

            if (isset($attendance[$student->id])) {
                foreach ($attendance[$student->id] as $att) {
                    $day = Carbon::parse($att->created_at)->day;
                    $data['attendance'][$day] = match ($att->status) {
                        'hadir' => 'H',
                        'izin' => 'I',
                        'sakit' => 'S',
                        'alpha' => 'A',
                        default => ''
                    };
                }
            }

            return $data;
        });

        return inertia('Admin/Reports/Absence/Student', [
            'attendance' => $attendanceData,
            'month' => $month,
            'classrooms' => $classrooms,
        ]);
    }

    public function export(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $classroomId = $request->input('classroom_id');

        $classroomName = 'Semua Kelas';
        if ($classroomId) {
            $classroom = Classroom::find($classroomId);
            $classroomName = $classroom ? $classroom->title : $classroomName;
        }

        // Fetch attendance data
        $attendance = AbsenceStudent::whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->get()
            ->groupBy('student_id');

        // Fetch students data
        $studentsQuery = Student::query();
        if ($classroomId) {
            $studentsQuery->where('classroom_id', $classroomId);
        }
        $students = $studentsQuery->get();

        // Prepare data for export
        $attendanceData = $students->map(function ($student) use ($attendance, $month) {
            $daysInMonth = Carbon::parse($month)->daysInMonth;
            $data = [
                'name' => $student->name,
                'attendance' => array_fill(1, $daysInMonth, ''),
            ];

            if (isset($attendance[$student->id])) {
                foreach ($attendance[$student->id] as $att) {
                    $day = Carbon::parse($att->created_at)->day;
                    $data['attendance'][$day] = match ($att->status) {
                        'hadir' => 'H',
                        'izin' => 'I',
                        'sakit' => 'S',
                        'alpha' => 'A',
                        default => ''
                    };
                }
            }

            return $data;
        });

        return Excel::download(new AttendanceExport($attendanceData, $month, $classroomName), 'attendance-' . $month . '.xlsx');
    }

    public function teacher(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $classroom_id = $request->get('classroom_id');
        $lesson_id = $request->get('lesson_id');

        $query = AbsenceTeacher::with(['classroom', 'lesson', 'teacher'])
            ->whereMonth('created_at', '=', substr($month, 5, 2))
            ->whereYear('created_at', '=', substr($month, 0, 4));

        if ($classroom_id) {
            $query->where('class_id', $classroom_id);
        }

        if ($lesson_id) {
            $query->where('lesson_id', $lesson_id);
        }

        $attendances = $query->get()->groupBy(function ($attendance) {
            return $attendance->teacher_id . '-' . $attendance->class_id . '-' . $attendance->lesson_id;
        });

        $attendanceData = [];
        foreach ($attendances as $key => $attendanceGroup) {
            list($teacherId, $classId, $lessonId) = explode('-', $key);
            $teacher = $attendanceGroup->first()->teacher;
            $classroom = $attendanceGroup->first()->classroom;
            $lesson = $attendanceGroup->first()->lesson;

            $attendanceRecord = [
                'name' => $teacher->name,
                'classroom' => $classroom->title,
                'lesson' => $lesson->title,
                'attendance' => [],
            ];

            for ($i = 1; $i <= 31; $i++) {
                $attendanceRecord['attendance'][$i] = '';
            }

            foreach ($attendanceGroup as $attendance) {
                $day = (int) $attendance->created_at->format('d');
                $attendanceRecord['attendance'][$day] = match ($attendance->status) {
                    'alpha' => 'A',
                    'hadir' => 'H',
                    'izin' => 'I',
                    'sakit' => 'S',
                    default => '',
                };
            }

            $attendanceData[] = $attendanceRecord;
        }

        // Group data by teacher name and classroom
        $groupedAttendanceData = [];
        foreach ($attendanceData as $record) {
            $name = $record['name'];
            $classroom = $record['classroom'];
            if (!isset($groupedAttendanceData[$name])) {
                $groupedAttendanceData[$name] = [];
            }
            if (!isset($groupedAttendanceData[$name][$classroom])) {
                $groupedAttendanceData[$name][$classroom] = [];
            }
            $groupedAttendanceData[$name][$classroom][] = $record;
        }

        return inertia('Admin/Reports/Absence/Teacher', [
            'attendance' => $groupedAttendanceData,
            'month' => $month,
            'classrooms' => Classroom::all(),
            'lessons' => Lesson::all(),
            'errors' => session()->get('errors') ? session()->get('errors')->getBag('default')->getMessages() : (object) [],
        ]);
    }



    public function exportTeacher(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $classroom_id = $request->get('classroom_id');
        $lesson_id = $request->get('lesson_id');

        $query = AbsenceTeacher::with(['classroom', 'lesson', 'teacher'])
            ->whereMonth('created_at', '=', substr($month, 5, 2))
            ->whereYear('created_at', '=', substr($month, 0, 4));

        if ($classroom_id) {
            $query->where('class_id', $classroom_id);
        }

        if ($lesson_id) {
            $query->where('lesson_id', $lesson_id);
        }

        $attendances = $query->get()->groupBy(function ($attendance) {
            return $attendance->teacher_id . '-' . $attendance->class_id . '-' . $attendance->lesson_id;
        });

        $attendanceData = [];
        foreach ($attendances as $key => $attendanceGroup) {
            list($teacherId, $classId, $lessonId) = explode('-', $key);
            $teacher = $attendanceGroup->first()->teacher;
            $classroom = $attendanceGroup->first()->classroom;
            $lesson = $attendanceGroup->first()->lesson;

            $attendanceRecord = [
                'name' => $teacher->name,
                'classroom' => $classroom->title,
                'lesson' => $lesson->title,
                'attendance' => [],
            ];

            for ($i = 1; $i <= 31; $i++) {
                $attendanceRecord['attendance'][$i] = '';
            }

            foreach ($attendanceGroup as $attendance) {
                $day = (int) $attendance->created_at->format('d');
                $attendanceRecord['attendance'][$day] = match ($attendance->status) {
                    'alpha' => 'A',
                    'hadir' => 'H',
                    'izin' => 'I',
                    'sakit' => 'S',
                    default => '',
                };
            }

            $attendanceData[] = $attendanceRecord;
        }

        $classroomTitle = Classroom::find($classroom_id)->title ?? 'Semua Kelas';

        return Excel::download(new AttendanceTeacherExport($attendanceData, $month, $classroomTitle), 'attendance-' . $month . '.xlsx');
    }
}
