@extends('layouts.admin.main')

@section('title', 'Galeri')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Galeri</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if ($gallery->tag == 'Video')
        {{-- Start Page Content --}}
        <div class="card mx-auto" style="width: 30rem;">
            @if ($gallery->tag == 'Foto')
                <img src="{{ asset('assets/img/gallery/' . $gallery->file) }}" class="card-image-top" alt="">
            @else
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $gallery->file }}" allowfullscreen></iframe>
                </div>
            @endif

            <div class="card-header">
                {{ $gallery->title }}
            </div>
            <div class="card-body">
                <P>{!! $gallery->content !!} </P>
            </div>
            <div class="card-footer text--muted mx-auto">
                <p>
                    Di Unggah pada {{ $gallery->created_at->isoFormat('D-MMMM-Y') }}
                </p>
                Di Update pada {{ $gallery->updated_at->isoFormat('D-MMMM-Y') }}
            </div>
            <hr>
            <a href="/admin/gallery" class="btn btn-warning mx-auto" style="justify-content-center">Kembali</a>
        </div>
        {{-- End Page Content --}}
    @else
        {{-- Start Page Content --}}
        <div class="text-center">
            <h1> {{ $gallery->title }}</h1>
            <P>{!! $gallery->content !!}</P>
        </div>
        <hr>
        <div class="card-group">
            @foreach ($data as $item)
                <div class="col-md-4 col-sm-4 col-xs-12 my-3">
                    <div class="card h-100 mx-2 shadow" style="border-radius: 30px">
                        <img src="{{ asset('assets/img/gallery/' . $item->file) }}" class="card-img-top" alt="..."
                            height="200px">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-muted text-center">
            <p>
                Di Unggah pada {{ $gallery->created_at->isoFormat('D-MMMM-Y') }}
            </p>
        </div>
        <hr>
        <div class="text-center">
            <a href="/admin/gallery" class="btn btn-warning mx-auto">Kembali</a>
        </div>
        {{-- End Page Content --}}
    @endif

@endsection
