<div class="container">
    <div class="header-bottom">
        <nav class="navbar navbar-expand-md navbar-light">
            <a class="navbar-brand" href="/">
                <div class="d-flex">
                    @if (Request::is('/'))
                        <img class="logo-light" src="{{ asset('logomanuril-long.png') }}" alt="logo" width="200">
                        <img class="logo-dark" src="{{ asset('logoma-long-white.png') }}" alt="logo" width="200">
                    @else
                        <img class="logo-light" src="{{ asset('logoma-long-white.png') }}" alt="logo"
                            width="200">
                        <img class="logo-dark" src="{{ asset('logoma-long-white.png') }}" alt="logo" width="200">
                    @endif
                </div>
            </a>
            <div class="collapse navbar-collapse main-menu-wrap" id="navbarSupportedContent">
                <div class="menu-close xl-none">
                    <a href="javascript:void(0)"> <i class="ri-close-line"></i></a>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tentang.home') }}" class="nav-link">
                            Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('prestasi.home') }}" class="nav-link">
                            Prestasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengajar.home') }}" class="nav-link">Pengajar</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('postingan.home') }}" class="nav-link">Postingan</a>
                    </li>
                    <li class="nav-item xl-none">
                        <a href="/login-siswa" class="btn style1">Login</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="mobile-bar-wrap">
            {{-- <div class="mobile-sidebar">
                <i class="ri-menu-4-line"></i>
            </div>
            <button class="searchbtn xl-none" type="button">
                <i class="flaticon-search"></i>
            </button> --}}
            <div class="mobile-menu xl-none p-2">
                <a href="javascript:void(0)"><i class="ri-menu-line"></i></a>
            </div>
        </div>
    </div>
    <div class="search-area">
        <div class="container">
            <form action="#">
                <div class="form-group">
                    <input type="search" placeholder="Search Here" autofocus>
                </div>
            </form>
            <button type="button" class="close-searchbox">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
