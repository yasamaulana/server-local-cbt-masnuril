@extends('layouts.app', ['title' => 'Postingan'])

@section('head')
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}" />
    <meta property="og:image" content="{{ asset('storage/' . $post->banner) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta name="twitter:card" content="summary_large_image">
@endsection


@section('main')
    <div class="blog-details-wrap ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-10 offset-xl-1">
                    <article>
                        <ul class="post-metainfo  list-style">
                            <li><i class="flaticon-user-1"></i> Admin</li>
                        </ul>
                        <h3>{{ $post->title }}</h3>
                        <div class="post-img">
                            <img src="{{ asset('storage/' . $post->banner) }}" alt="Image">
                        </div>
                        <div class="post-para">
                            <p class="blog-date">{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}</p>
                            {!! $post->content !!}
                        </div>
                    </article>
                    <div class="row gx-0 align-items-center">
                        <div class="col text-md-end text-start">
                            @php
                                $shareUrl = route('post.detail', $post->slug);
                            @endphp

                            <div class="post-share w-100">
                                <span>Share:</span>
                                <ul class="social-profile style2 list-style">
                                    <li>
                                        <a target="_blank"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}">
                                            <i class="ri-facebook-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                            href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . $shareUrl) }}">
                                            <i class="ri-whatsapp-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                            href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($post->title) }}">
                                            <i class="ri-twitter-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                            href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($post->title) }}">
                                            <i class="ri-telegram-fill"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <h6>Postingan Lainnya</h6>
                    <div class="row justify-content-center">
                        @forelse ($posts as $post)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="blog-card h-100 style3">
                                    <div class="blog-img">
                                        <img src="{{ asset('storage/' . $post->banner) }}" alt="Image">
                                        <p class="blog-date">{{ \Carbon\Carbon::parse($post->created_at)->format('d M') }}
                                        </p>
                                    </div>
                                    <div class="blog-info">
                                        <a href="{{ route('post.detail', ['slug' => $post->slug]) }}" class="blog-link"><i
                                                class="flaticon-right-arrow"></i>
                                        </a>
                                        <h3><a
                                                href="{{ route('post.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
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
                </div>
            </div>
        </div>
    </div>
@endsection
