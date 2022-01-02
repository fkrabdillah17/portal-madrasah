@extends('layouts.admin.main')

@section('title', 'Berita')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Berita</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="card mx-auto" style="width: 45rem;">
        <img src="{{ asset('assets/img/news/' . $news->thumbnail) }}" class="card-image-top" alt="">
        <div class="col mx-1">
            <div class="row">
                <i class="bi bi-tag-fill mx-1"> {{ $news->newsCategory->category }}</i>
                <i class="bi bi-person-fill mx-1"> {{ $news->createBy->name }}</i>
                @if ($news->status == 'Published')
                    <i class="bi bi-calendar mx-1"> {{ $news->published_at->isoFormat('D-MMMM-Y') }}</i>
                @else
                    <i class="bi bi-calendar mx-1 text-uppercase"> {{ $news->status }}</i>
                @endif
            </div>
        </div>
        <div class="card-header">
            {{ $news->title }}
        </div>
        <div class="card-body">
            <P>{!! $news->content !!} </P>
        </div>
        <div class="card-footer text--muted mx-auto text-center">
            <p>Di perbarui oleh {{ $news->updateBy->name }}</p>
            <p>Di Unggah pada {{ $news->created_at->isoFormat('D-MMMM-Y') }}</p>
            <p>Di Update pada {{ $news->updated_at->isoFormat('D-MMMM-Y') }}</p>
            <hr>
            <a href="/admin/news" class="btn btn-warning mx-auto">Kembali</a>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
