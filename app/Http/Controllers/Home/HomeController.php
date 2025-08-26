<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Keterserapan;
use App\Models\Lesson;
use App\Models\Prestasi;
use App\Models\Mitra;
use App\Models\Post;
use App\Models\StrukturOrganisasi;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $prestasis = Prestasi::paginate(3);
        // $mitras = Mitra::paginate(3);
        // $strukturOrganisasis = StrukturOrganisasi::all();
        // $gurus = Teacher::inRandomOrder()->limit(3)->get();
        // $keterserapans = Keterserapan::all();

        // return view('home', [
        //     'prestasis' => $prestasis,
        //     'mitras' => $mitras,
        //     'strukturOrganisasis' => $strukturOrganisasis,
        //     'gurus' => $gurus,
        //     'keterserapans' => $keterserapans,
        //     'jumlahKelas' => Classroom::count(),
        //     'jumlahSiswa' => Student::count(),
        //     'jumlahGuru' => Teacher::count(),
        //     'jumlahJadwal' => Lesson::count(),
        //     'posts' => Post::inRandomOrder()->where('status', 'published')->limit(3)->get()
        // ]);

        return redirect('/login');
    }

    public function tentangKami()
    {
        return view('pages.tentang');
    }

    public function semuaPengajar()
    {
        return view('pages.guru', [
            'pengajar' => Teacher::all()
        ]);
    }

    public function pretasiSiswa()
    {
        return view('pages.prestasi', [
            'prestasis' => Prestasi::all()
        ]);
    }

    public function semuaPostingan()
    {
        return view('pages.postingan', [
            'posts' => Post::where('status', 'published')->paginate(9)
        ]);
    }

    public function postDetail($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $posts = Post::inRandomOrder()
            ->where('slug', '!=', $slug)
            ->limit(3)
            ->get();

        return view('pages.single-post', [
            'post' => $post,
            'posts' => $posts
        ]);
    }
}
