@extends('layouts.app', ['title' => 'Prestasi Siswa'])

@section('main')
    <div class="container">
        <div class="row ptb-100">
            @foreach ($prestasis as $item)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-img-top-wrapper" style="height: 250px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Image" class="w-100 h-100"
                                style="object-fit: cover; object-position: center;" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text">{{ $item->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
