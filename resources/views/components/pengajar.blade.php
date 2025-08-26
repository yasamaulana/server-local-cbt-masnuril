<section class="team-wrap ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
                <div class="section-title style1 text-center mb-40">
                    <span>Pegawai</span>
                    <h2>Pegawai di MA Nurul Ilmi</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
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
        <div class="text-center mt-10">
            <a href="{{ route('pengajar.home') }}" class="btn style1">Lihat Semua Guru <i
                    class="flaticon-right-arrow"></i></a>
        </div>
    </div>
</section>
