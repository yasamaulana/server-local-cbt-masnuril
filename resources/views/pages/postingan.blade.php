@extends('layouts.app', ['title' => 'Postingan'])

@section('main')
    <div class="blog-details-wrap ptb-100">
        <div class="container">
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
                        <div class="alert alert-warning text-center">
                            <strong>Oops!</strong> Postingan belum tersedia.
                        </div>
                    </div>
                @endforelse

            </div>
            @if ($posts->hasPages())
                <div class="page-navigation mt-10">
                    <ul class="page-nav list-style">
                        {{-- Tombol "Previous" --}}
                        @if ($posts->onFirstPage())
                            <li><span><i class="flaticon-left-arrow"></i></span></li>
                        @else
                            <li><a href="{{ $posts->previousPageUrl() }}"><i class="flaticon-left-arrow"></i></a></li>
                        @endif

                        {{-- Nomor Halaman --}}
                        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            @if ($page == $posts->currentPage())
                                <li><a class="active" href="#">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Tombol "Next" --}}
                        @if ($posts->hasMorePages())
                            <li><a href="{{ $posts->nextPageUrl() }}"><i class="flaticon-right-arrow-1"></i></a></li>
                        @else
                            <li><span><i class="flaticon-right-arrow-1"></i></span></li>
                        @endif
                    </ul>
                </div>
            @endif

        </div>
    </div>
@endsection
