{{-- <div class="welcomeanimation">
    <div class="px-2 row">
        <div class="col-auto text-warp">MTsN 1 Kota Bengkulu</div>
        <marquee class="col-8 bg-mts">Selamat datang di website resmi MTsN 1 Kota Bengkulu, Hebat Bermartabat
        </marquee>
        <div class="col-auto text-warp">MTsN 1 Kota Bengkulu</div>
    </div>
</div> --}}
<div class="sticky-top">
    <nav class="navbar navbar-expand-xl navbar-light bg-navbar"
        style="border-bottom-right-radius: 30px;border-bottom-left-radius: 30px">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('/assets/img/logo/Logo.png') }}" height="50px" width="60px" alt="logo">
                <small style="font-size: 20px">MTsN 1 Kota Bengkulu</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-end" id="navbarSupportedContent">
                <ul class="navbar-nav me-5 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-uppercase {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                            href="/">beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase {{ request()->is('profil*') ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            profil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($profile as $item)
                                <li><a class="dropdown-item text-uppercase {{ request()->segment(2) == $item->category->name ? 'active' : '' }}"
                                        href="{{ route('profile', ['slug' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase {{ request()->segment(1) == 'akademik' ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Akademik
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($academics as $item)
                                <li><a class="dropdown-item text-uppercase {{ request()->segment(5) == $item->category->name ? 'active' : '' }}"
                                        href="{{ route('akademik', ['year' => $item->created_at->format('Y'), 'mounth' => $item->created_at->format('m'), 'tag' => $item->tag, 'name' => $item->category->name]) }}">{{ $item->category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase {{ request()->segment(1) == 'kesiswaan' ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kesiswaan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($kesiswaan as $item)
                                <li><a class="dropdown-item text-uppercase {{ request()->segment(2) == $item->slug ? 'active' : '' }}"
                                        href="{{ route('kesiswaan', [($tag = $item->slug)]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-uppercase {{ request()->segment(1) == 'berita' ? 'active' : '' }}"
                            href="{{ route('News') }}">Berita</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase {{ request()->is('staff*') ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Staff
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($staff as $item)
                                <li><a class="dropdown-item text-uppercase {{ request()->segment(2) == $item->slug ? 'active' : '' }}"
                                        href="{{ route('staff', ['category' => $item->slug]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase {{ request()->segment(1) == 'layanan' ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Layanan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($link as $item)
                                <li>
                                    <a class="dropdown-item" href="{{ $item->content }}" target="_blank">
                                        <span style="text-transform:uppercase">{{ $item->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                            <hr>
                            @foreach ($layanan as $item)
                                <li>
                                    <a class="dropdown-item {{ request()->segment(2) == $item->slug ? 'active' : '' }}"
                                        href="/layanan/{{ $item->slug }}">
                                        <span style="text-transform:uppercase">{{ $item->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase {{ request()->segment(1) == 'galeri-foto' || request()->segment(1) == 'galeri-video' ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            galeri
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item text-uppercase {{ request()->segment(1) == 'galeri-foto' ? 'active' : '' }}"
                                    href="{{ route('GalleryPhoto') }}">foto</a></li>
                            <li><a class="dropdown-item text-uppercase {{ request()->segment(1) == 'galeri-video' ? 'active' : '' }}"
                                    href="{{ route('GalleryVideo') }}">video</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase {{ request()->segment(1) == 'unduh' ? 'active' : '' }}"
                            href="{{ route('unduh') }}">Unduh</a>
                    </li>
                    @if (request()->segment(1) == 'berita')
                        <li class="nav-item">
                            <!-- Button trigger modal -->
                            <button id="searchButton" type="button" class="btn " data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="bi bi-search text-custom"></i>
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Pencarian Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="get" action="{{ route('search') }}" role="search">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea class="form-control @error('keyword') is-invalid @enderror" id="keyword"
                            name="keyword" placeholder="Tulis Di Sini" required></textarea>
                        @error('keyword')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
