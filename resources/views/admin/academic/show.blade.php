@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Akademik</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @php
    if ($academic->tag == 1) {
        $kategori = 'Kurikulum';
    } elseif ($academic->tag == 2) {
        $kategori = 'Jadwal Pelajaran';
    } elseif ($academic->tag == 3) {
        $kategori = 'Ekstrakurikuler';
    } elseif ($academic->tag == 4) {
        $kategori = 'Fasilitas';
    }
    @endphp

    {{-- Start Page Content --}}
    <div class="card mx-auto" style="width: 30rem;">
        <img src="{{ asset('assets/img/academic/' . $academic->file) }}" class="card-image-top" alt="">
        <div class="col mx-1">
            <div class="row">
                <i class="bi bi-tag-fill mx-1"> {{ $kategori }}</i>
                <i class="bi bi-person-fill mx-1"> {{ $academic->createdBy->name }}</i>
            </div>
        </div>
        <div class="card-header">
            {{ $academic->title }}
        </div>
        <div class="card-body">
            <P>{!! $academic->description !!} </P>
        </div>
        <div class="card-footer text--muted mx-auto text-center">
            <p>Di perbarui oleh {{ $academic->updatedBy->name }}</p>
            <p>Di Unggah pada {{ $academic->created_at->isoFormat('D-MMMM-Y') }}</p>
            <p>Di Update pada {{ $academic->updated_at->isoFormat('D-MMMM-Y') }}</p>
            <hr>
            <a href="{{ route('academic.index') }}" class="btn btn-warning mx-auto">Kembali</a>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
