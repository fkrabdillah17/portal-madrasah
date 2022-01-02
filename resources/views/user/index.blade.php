@extends('layouts.user.main2')

@section('content')
    {{-- Start Carousel --}}
    <div class="container-lg">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                @for ($i = 1; $i < $count; $i++)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $i }}"
                        aria-label="Slide {{ $i + 1 }}"></button>
                @endfor

            </div>
            <div class="carousel-inner">
                @foreach ($slider as $item)
                    @if ($item->title == 'Welcome Slide')
                        <div class="carousel-item drk active">
                            <img src="{{ asset('assets/img/slider/' . $item->file) }}" class="d-block w-100 h-100"
                                alt="...">
                            <div class="carousel-caption slide-pertama">
                                <h1>Selamat Datang</h1>
                                <p>Selamat Datang di Website Resmi MTsN 1 Kota Bengkulu</p>
                            </div>
                        </div>
                    @else
                        <div class="carousel-item">
                            <img src="{{ asset('assets/img/slider/' . $item->file) }}" class="d-block w-100 h-100"
                                alt="...">
                        </div>
                    @endif
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    {{-- End Carousel --}}

    {{-- Start Sambutan --}}
    {{-- <div class="container my-3">
        <div class="row g-0">
            <div class="card mb-3" style="max-height: 300px">
                <div class=" row g-0">
                    <div class="col-auto">
                        <img src="{{ asset('assets/img/Sambutan.png') }}" class="rounded-start" height="300px"
                            width="250px" alt="...">
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <h4 class="card-title">Eza Avlenda,S.Pd.,M.Si.</h4>
                            <h4 class="card-title"><small class="text-muted">Kepala Madrasah</small></h4>
                            <p class="card-text">This is a wider card with supporting text below as a natural
                                lead-in
                                to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('assets/img/logo/Logo.png') }}" class="card-img px-auto py-auto" height="250px"
                            alt="...">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- End Sambutan --}}

    {{-- Start News --}}
    <div class="container mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h2><span class="font-weight-bold">Kabar MTsN</span></h2>
            <hr class="costum my-1">
        </div>
        <div class="card-group">
            @foreach ($news as $n)
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="card h-100 mx-2 shadow" style="border-radius: 30px">
                        <a href="{{ route('show-berita', $n->slug) }}" class="LinkBerita">
                            <img src="{{ asset('assets/img/news/' . $n->thumbnail) }}" class="card-img-top" alt="..."
                                height="200px">
                        </a>
                        <p class="card-text mt-1 mx-1">
                            <small class="text-muted">
                                {{ $n->updated_at->diffForHumans() }} ~ {{ $n->createBy->name }} ~
                                <i class="bi bi-bookmark-dash-fill"
                                    style="color: blue">{{ $n->newsCategory->category }}</i>
                            </small>
                        </p>
                        <hr class="my-0">
                        <div class="card-body">
                            <a href="{{ route('show-berita', $n->slug) }}" class="linkBerita">
                                <h5 class="card-title">{{ $n->title }}</h5>
                            </a>
                            <p class="card-text">{!! \Illuminate\Support\Str::limit($n->content, 200, $end = '...') !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- End News --}}
    {{-- Start Foto --}}
    @if ($cekFoto != 0)
        <div class="container mt-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="diveder">
                    <h2><span class="font-weight-bold">Galeri Foto</span></h2>
                    <hr class="costum my-1">
                </div>
            </div>
            <div class="card-group">
                @foreach ($dataFoto as $foto)
                    <div class="col-md-4 col-sm-4 col-xs-12 my-3">
                        <div class="card h-100 mx-2 shadow" style="border-radius: 30px">
                            <a href="{{ route('show-foto', $foto->slug) }}" class="LinkBerita">
                                <img src="{{ asset('assets/img/gallery/' . $foto->file) }}" class="card-img-top"
                                    alt="..." height="200px">
                            </a>
                            <hr class="my-0">
                            <div class="card-body">
                                <a href="{{ route('show-foto', $foto->slug) }}" class="linkBerita">
                                    <h5 class="card-title">{{ $foto->title }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    {{-- End Foto --}}

    {{-- Start Video --}}
    @if ($cekVideo != 0)
        <div class="container mt-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="diveder">
                    <h2><span class="font-weight-bold">Galeri Video</span></h2>
                    <hr class="costum my-1">
                </div>
            </div>
            <div class="card-group">
                @foreach ($video as $v)
                    <div class="col-md-4 col-sm-4 col-xs-12 my-3">
                        <div class="card  h-100 mx-2 shadow" style="border-radius: 30px">
                            <div class="ratio ratio-16x9">
                                <iframe class="embed-responsive-item" src="{{ $v->file }}" allowfullscreen></iframe>
                            </div>
                            <hr class="my-0">
                            <div class="card-body">
                                <h5 class="card-title">{{ $v->title }}</h5>
                                <p class="card-text">{!! \Illuminate\Support\Str::limit($v->content, 200, $end = '...') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    {{-- End Video --}}
@endsection
