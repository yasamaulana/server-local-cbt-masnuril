@extends('layouts.app', ['title' => 'Pengajar'])

@section('main')
    <div class="container">
        <div class="row ptb-100">
            @foreach ($pengajar as $item)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="team-card style3">
                        <div class="team-img">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Image">
                            <div class="team-info">
                                <h3 class="text-white">{{ $item->name }}</h3>
                                <span>{{ $item->position }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
