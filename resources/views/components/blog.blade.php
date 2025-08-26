<section class="blog-wrap pt-100 pb-75 bg-concrete">
    <div class="container">
        <div class="section-title style1 text-center mb-40">
            <span>Postingan Terakhir</span>
            <h2>Baca Postingan Terakhir Kami</h2>
        </div>
        <div class="row justify-content-center">
            @forelse ($posts as $post)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="blog-card h-100 style3">
                        <div class="blog-img">
                            <img src="{{ asset('storage/' . $post->banner) }}" alt="Image">
                            <p class="blog-date">{{ \Carbon\Carbon::parse($post->created_at)->format('d M') }}</p>
                        </div>
                        <div class="blog-info">
                            <a href="{{ route('post.detail', ['slug' => $post->slug]) }}" class="blog-link"><i
                                    class="flaticon-right-arrow"></i>
                            </a>
                            <h3><a href="{{ route('post.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 15, '...') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Tidak ada postingan yang tersedia saat ini.
                    </div>
                </div>
            @endforelse

        </div>
        <div class="text-center mt-10">
            <a href="{{ route('postingan.home') }}" class="btn style1">Lihat Semua Postingan <i
                    class="flaticon-right-arrow"></i></a>
        </div>
    </div>
</section>
