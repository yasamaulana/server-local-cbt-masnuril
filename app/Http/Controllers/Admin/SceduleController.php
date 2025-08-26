<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Scedule;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SceduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get scedule
        $scedules = Scedule::when(request()->q, function ($scedules) {
            $scedules = $scedules->where('day', 'like', '%' . request()->q . '%');
        })
            ->with(['teacher', 'lesson', 'class'])
            ->latest()->paginate(5);

        //append query string to pagination links
        $scedules->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Scedule/Index', [
            'scedules' => $scedules,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Scedule/Create', [
            'teachers' => Teacher::all(),
            'lessons' => Lesson::all(),
            'classrooms' => Classroom::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'lesson_id' => 'required|exists:lessons,id',
            'class_id' => 'required|exists:classrooms,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
        ]);

        // Create the schedule
        Scedule::create($validated);

        // Redirect with a success message
        return redirect()->route('admin.scedule.index')->with('success', 'Jadwal Berhasil Disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Scedule $scedule)
    {
        return inertia('Admin/Scedule/Edit', [
            'scedule' => $scedule,
            'teachers' => Teacher::all(),
            'lessons' => Lesson::all(),
            'classrooms' => Classroom::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scedule $scedule)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'lesson_id' => 'required|exists:lessons,id',
            'class_id' => 'required|exists:classrooms,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Create the schedule
        $scedule->update($validated);

        // Redirect with a success message
        return redirect()->route('admin.scedule.index')->with('success', 'Jadwal Berhasil Diedit.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scedule $scedule)
    {
        $scedule->delete();

        //redirect
        return redirect()->route('admin.scedule.index');
    }
}
