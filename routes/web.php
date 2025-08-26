<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PPDBController as AdminPPDBController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PPDBController;

//home page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-ma-nurul-ilmi', [HomeController::class, 'tentangKami'])->name('tentang.home');
Route::get('/semua-pengajar', [HomeController::class, 'semuaPengajar'])->name('pengajar.home');
Route::get('/prestasi-siswa', [HomeController::class, 'pretasiSiswa'])->name('prestasi.home');
Route::get('/semua-postingan', [HomeController::class, 'semuaPostingan'])->name('postingan.home');
Route::get('/post/{slug}', [HomeController::class, 'postDetail'])->name('post.detail');

//route login
Route::get('/login-siswa', function () {

    //cek session student
    if (auth()->guard('student')->check()) {
        return redirect()->route('student.dashboard');
    }

    //return view login
    return \Inertia\Inertia::render('Student/Login/Index');
});

//ppdb route
Route::prefix('penerimaan-peserta-didik-baru')->group(function () {
    Route::get('/', [PPDBController::class, 'index'])->name('ppdb');
    Route::get('/penerimaan', [PPDBController::class, 'index'])->name('ppdb');
    //ppdb page
    Route::post('/pendaftaran', [PPDBController::class, 'simpanDataSiswa'])->name('pendaftaran.store');
    Route::get('/pendaftaran-berhasil', [PPDBController::class, 'berhasilMendaftar'])->name('pendaftaran.berhasil');
    //route ppdb status
    Route::get('/status-pendaftaran', [PPDBController::class, 'statusPendaftaran'])->name('ppdb.status');
    Route::get('/cek-hasil-pendaftaran', [PPDBController::class, 'cekHasilPendaftaran'])->name('cek.hasil.ajax');
});

//prefix "admin"
Route::prefix('admin')->group(function () {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');

        //route resource schools    
        Route::resource('/schools', \App\Http\Controllers\Admin\SchoolController::class, ['as' => 'admin']);

        //route resource lessons    
        Route::resource('/lessons', \App\Http\Controllers\Admin\LessonController::class, ['as' => 'admin']);

        //route resource classrooms    
        Route::resource('/classrooms', \App\Http\Controllers\Admin\ClassroomController::class, ['as' => 'admin']);

        //route student import
        Route::get('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'import'])->name('admin.students.import');

        //route student store import
        Route::post('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'storeImport'])->name('admin.students.storeImport');

        //route resource students    
        Route::resource('/students', \App\Http\Controllers\Admin\StudentController::class, ['as' => 'admin']);

        //route resource teachers    
        Route::resource('/teachers', \App\Http\Controllers\Admin\TeacherController::class, ['as' => 'admin']);

        //route student import
        Route::get('/teachers/import', [\App\Http\Controllers\Admin\TeacherController::class, 'import'])->name('admin.teachers.import');

        //route student store import
        Route::post('/teachers/import', [\App\Http\Controllers\Admin\TeacherController::class, 'storeImport'])->name('admin.teachers.storeImport');

        //ppdb
        Route::get('/ppdb', [AdminPPDBController::class, 'index'])->name('admin.ppdb');
        Route::get('/ppdb/{id}/show', [AdminPPDBController::class, 'show'])->name('admin.ppdb.show');
        Route::post('/ppdb/bulk-update-status', [AdminPPDBController::class, 'bulkUpdateStatus']);
        Route::get('/ppdb/export', [AdminPPDBController::class, 'export'])->name('ppdb.export');

        //route resource prestasi    
        Route::resource('/prestasi', \App\Http\Controllers\Admin\PrestasiController::class, ['as' => 'admin']);

        //route resource keterserapan  
        Route::resource('/keterserapan', \App\Http\Controllers\Admin\KeterserapanController::class, ['as' => 'admin']);

        //route resource mitra   
        Route::resource('/kemitraan', \App\Http\Controllers\Admin\MitraController::class, ['as' => 'admin']);

        //postingan
        Route::resource('/postingan', PostController::class, ['as' => 'admin']);
        Route::put('/postingan/{id}/status', [PostController::class, 'updateStatus']);

        //route resource Struktur Organisasi  
        Route::resource('/struktur-organisasi', \App\Http\Controllers\Admin\StrukturOrganisasiController::class, ['as' => 'admin']);

        //route scedule
        Route::resource('/scedule', \App\Http\Controllers\Admin\SceduleController::class, ['as' => 'admin']);

        //route resource exams    
        Route::resource('/exams', \App\Http\Controllers\Admin\ExamController::class, ['as' => 'admin']);

        //custom route for create question exam
        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Admin\ExamController::class, 'createQuestion'])->name('admin.exams.createQuestion');

        //custom route for store question exam
        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Admin\ExamController::class, 'storeQuestion'])->name('admin.exams.storeQuestion');

        //custom route for edit question exam
        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'editQuestion'])->name('admin.exams.editQuestion');

        //custom route for update question exam
        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Admin\ExamController::class, 'updateQuestion'])->name('admin.exams.updateQuestion');

        //custom route for destroy question exam
        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Admin\ExamController::class, 'destroyQuestion'])->name('admin.exams.destroyQuestion');

        //route student import
        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'import'])->name('admin.exam.questionImport');

        //route student import
        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'storeImport'])->name('admin.exam.questionStoreImport');

        //route resource exam_sessions    
        Route::resource('/exam_sessions', \App\Http\Controllers\Admin\ExamSessionController::class, ['as' => 'admin']);

        //custom route for enrolle create
        Route::get('/exam_sessions/{exam_session}/enrolle/create', [\App\Http\Controllers\Admin\ExamSessionController::class, 'createEnrolle'])->name('admin.exam_sessions.createEnrolle');

        //custom route for enrolle store
        Route::post('/exam_sessions/{exam_session}/enrolle/store', [\App\Http\Controllers\Admin\ExamSessionController::class, 'storeEnrolle'])->name('admin.exam_sessions.storeEnrolle');

        //custom route for enrolle destroy
        Route::delete('/exam_sessions/{exam_session}/enrolle/{exam_group}/destroy', [\App\Http\Controllers\Admin\ExamSessionController::class, 'destroyEnrolle'])->name('admin.exam_sessions.destroyEnrolle');

        //route index reports
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');

        //route index reports filter
        Route::get('/reports/filter', [\App\Http\Controllers\Admin\ReportController::class, 'filter'])->name('admin.reports.filter');

        //route index reports export
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

        //report page absence student
        Route::get('/presence-student', [\App\Http\Controllers\Admin\ReportAbsenceController::class, 'student'])->name('admin.absence.student');
        Route::get('/presence-student/export', [\App\Http\Controllers\Admin\ReportAbsenceController::class, 'export'])->name('admin.absence.student.export');

        //export page absence teacher
        Route::get('/presence-teacher', [\App\Http\Controllers\Admin\ReportAbsenceController::class, 'teacher'])->name('admin.absence.teacher');
        Route::get('/presence-teacher/export', [\App\Http\Controllers\Admin\ReportAbsenceController::class, 'exportTeacher'])->name('admin.absence.teacher.export');
    });
});

//login students
Route::post('/students/login', \App\Http\Controllers\Student\LoginController::class)->name('student.login');

//prefix "student"
Route::prefix('student')->group(function () {

    //middleware "student"
    Route::group(['middleware' => 'student'], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Student\DashboardController::class)->name('student.dashboard');

        //list exam enrole
        Route::get('/list-exam', App\Http\Controllers\Student\ListExamController::class)->name('student.list-exam');

        //presence student
        Route::get('/presence', App\Http\Controllers\Student\PresenceController::class)->name('presence');
        Route::post('/presence-submit', [App\Http\Controllers\Student\PresenceController::class, 'studentPresence'])->name('presence.submit');
        Route::get('/check-absensi-today', [App\Http\Controllers\Student\PresenceController::class, 'checkAbsensiTodayStudent'])->name('presence.cek');

        //presence teacher
        Route::get('/presence-teacher', App\Http\Controllers\Teacher\PresenceController::class)->name('presence.teacher');
        Route::post('/presence-submit-teacher', [App\Http\Controllers\Teacher\PresenceController::class, 'teacherPresence'])->name('presence.teacher.submit');
        Route::get('/check-absensi-today-teacher', [App\Http\Controllers\Teacher\PresenceController::class, 'checkAbsensiTodayTeacher'])->name('presence.teacher.cek');

        //route exam confirmation
        Route::get('/exam-confirmation/{id}', [App\Http\Controllers\Student\ExamController::class, 'confirmation'])->name('student.exams.confirmation');

        //route exam start
        Route::get('/exam-start/{id}', [App\Http\Controllers\Student\ExamController::class, 'startExam'])->name('student.exams.startExam');

        //route exam show
        Route::get('/exam/{id}/{page}', [App\Http\Controllers\Student\ExamController::class, 'show'])->name('student.exams.show');

        //route exam update duration
        Route::put('/exam-duration/update/{grade_id}', [App\Http\Controllers\Student\ExamController::class, 'updateDuration'])->name('student.exams.update_duration');

        //route answer question
        Route::post('/exam-answer', [App\Http\Controllers\Student\ExamController::class, 'answerQuestion'])->name('student.exams.answerQuestion');

        //route exam end
        Route::post('/exam-end', [App\Http\Controllers\Student\ExamController::class, 'endExam'])->name('student.exams.endExam');

        //route exam result
        Route::get('/exam-result/{exam_group_id}', [App\Http\Controllers\Student\ExamController::class, 'resultExam'])->name('student.exams.resultExam');
    });
});
