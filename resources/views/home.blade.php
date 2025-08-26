@extends('layouts.app')

@section('main')
    <!-- Hero Section Start -->
    <x-hero :prestasis="$prestasis" />
    <!-- Hero Section End -->

    <!-- About Section Start -->
    <x-sambutan></x-sambutan>
    <!-- About Section End -->

    <!-- Prestasi Section Start -->
    <x-prestasi :prestasis="$prestasis" />
    <!-- Prestasi Section End -->

    <!-- Mengapa Nurul Ilmi Section Start -->
    <x-mengapakami></x-mengapakami>
    <!-- Mengapa Nurul Ilmi Section End -->

    <!-- Counter Section start -->
    <div class="counter-area style1">
        <div class="container">
            <div class="counter-card-wrap">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                        <div class="counter-card">
                            <span class="counter-icon">
                                <i class="flaticon-graduated"></i>
                            </span>
                            <div class="counter-text">
                                <h2 class="counter-num">
                                    <span class="odometer" data-count="{{ $jumlahSiswa }}"></span>
                                    <span class="target">+</span>
                                </h2>
                                <p>Siswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                        <div class="counter-card">
                            <span class="counter-icon">
                                <i class="flaticon-teacher"></i>
                            </span>
                            <div class="counter-text">
                                <h2 class="counter-num">
                                    <span class="odometer" data-count="{{ $jumlahGuru }}"></span>
                                    <span class="target">+</span>
                                </h2>
                                <p>Guru</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                        <div class="counter-card">
                            <span class="counter-icon">
                                <i class="ri-building-2-line"></i>
                            </span>
                            <div class="counter-text">
                                <h2 class="counter-num">
                                    <span class="odometer" data-count="{{ $jumlahKelas }}"></span>
                                    <span class="target">+</span>
                                </h2>
                                <p>Kelas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                        <div class="counter-card">
                            <span class="counter-icon">
                                <i class="ri-book-2-line"></i>
                            </span>
                            <div class="counter-text">
                                <h2 class="counter-num">
                                    <span class="odometer" data-count="{{ $jumlahJadwal }}"></span>
                                    <span class="target">+</span>
                                </h2>
                                <p>Jadwal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Counter Section End -->

    <!-- Team Section Start -->
    <x-pengajar :pengajar="$gurus" />
    <!-- Team Section End -->

    <!-- CTA Section Start -->
    <x-mulaisekarang />
    <!-- CTA Section End -->

    <!-- Blog Section Start -->
    <x-blog :posts="$posts" />
    <!-- Blog Section End -->
@endsection
