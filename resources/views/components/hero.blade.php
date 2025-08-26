<div class="hero-wrap style3">
    <div class="container-fluid">
        <div class="row gx-0">
            <div class="col-xl-6 col-lg-5 col-md-5">
                <div class="hero-img-slider owl-carousel">
                    @foreach ($prestasis as $item)
                        <div class="ratio ratio-1x1 overflow-hidden rounded" style="height: 700px; max-height: 700px;">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Kepala Sekolah"
                                class="w-100 h-100 object-fit-cover">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-6 col-lg-7 col-md-7">
                <div class="hero-content-wrap">
                    <div class="hero-content" data-speed="0.10" data-revert="true">
                        <h1 data-aos="fade-up" data-aos-duration="1200" data-aos-delay="300">MADRASAH ALIYAH NURUL ILMI
                        </h1>
                        <p data-aos="fade-up" data-aos-duration="1200" data-aos-delay="400">Menjunjung tinggi nilai
                            agama, memperdalam pemahaman kitab kuning, dan menyeimbangkan ilmu dunia dan akhirat.
                        </p>
                        <a href="{{ route('ppdb') }}" class="btn style1" data-aos="fade-up" data-aos-duration="1200"
                            data-aos-delay="500">Daftar Sekarang</a>
                        <a href="{{ route('ppdb.status') }}" class="btn style3" data-aos="fade-up"
                            data-aos-duration="1200" data-aos-delay="500">Cek Hasil Pendaftaran</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
