<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TeachersImport;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get teachers
        $teachers = Teacher::when(request()->q, function ($teachers) {
            $teachers = $teachers->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $teachers->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Teachers/Index', [
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Teachers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers',
            'gender' => 'required|in:L,P',
            'address' => 'required|string|max:255',
            'position' => 'required|in:Guru,Staf,Kepala Sekolah',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru', 'public');
        }

        // Create a new teacher
        Teacher::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'position' => $validated['position'],
            'foto' => $fotoPath,
        ]);

        // Redirect with success message
        return redirect()->route('admin.teachers.index');
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
    public function edit(Teacher $teacher)
    {
        return inertia('Admin/Teachers/Edit', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:L,P',
            'address' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->gender = $request->gender;
        $teacher->address = $request->address;
        $teacher->position = $request->position;

        if ($request->hasFile('foto')) {
            if ($teacher->foto) {
                Storage::delete($teacher->foto);
            }
            $teacher->foto = $request->file('foto')->store('guru', 'public');
        }

        $teacher->save();

        return redirect()->route('admin.teachers.index')->with('success', 'Guru Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        // Delete the photo if it exists
        if ($teacher->foto) {
            Storage::delete($teacher->foto);
        }

        // Delete the teacher record
        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Guru Berhasil Dihapus');
    }

    /* import
    *
    * @return void
    */
    public function import()
    {
        return inertia('Admin/Teachers/Import');
    }

    /**
     * storeImport
     *
     * @param  mixed $request
     * @return void
     */
    public function storeImport(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new TeachersImport(), $request->file('file'));

        //redirect
        return redirect()->route('admin.students.index');
    }
}
