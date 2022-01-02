@extends('layouts.user.main')

@section('content')
    @if ($countdata != 0)
        <h1 class="text-center">Pencarian Berita"{{ $key }}"</h1>
        <hr>
    @else
        <h1 class="text-center">Pencarian Berita"{{ $key }}" Tidak Ada</h1>
        <hr>
    @endif

    @foreach ($data as $d)
        <div class="card my-3 shadow pb-3">
            <div class="row g-0">
                <div class="thumbnail-custom col-md-5">
                    <a href="{{ route('show-berita', $d->slug) }}">
                        <img src="{{ asset('assets/img/news/' . $d->thumbnail) }}" class="img-thumbnail"
                            style="height: 182px; width: 100%" alt="...">
                    </a>
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('show-berita', $d->slug) }}"
                                class="linkBerita">{{ $d->title }}</a></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                {{ $d->created_at->diffForHumans() }} ~ di unggah oleh {{ $d->createBy->name }} ~
                                <a href="{{ route('kategori-berita', $d->newsCategory->category) }}"
                                    class="linkBerita">
                                    <i class="bi bi-bookmark-dash-fill" style="color: blue">
                                        {{ $d->newsCategory->category }}
                                    </i>
                                </a>
                            </small>
                        </p>
                        <p class="card-text">{!! \Illuminate\Support\Str::limit($d->content, 100, $end = '...') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endsection
