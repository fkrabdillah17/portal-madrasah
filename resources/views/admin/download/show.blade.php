@extends('layouts.admin.main')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        {{-- Start Page Content --}}
        <h2 class="text-center">{{ $download->title }}</h2>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe type="application/pdf" class="iframe-responsive-item" src="/assets/files/{{ $download->file }}"
                allowfullscreen></iframe>
        </div>
        {{-- End Page Content --}}
        <div class="card-footer text--muted mx-auto text-center">
            <p>Di unggah oleh {{ $download->createdBy->name }} pada {{ $download->created_at->isoFormat('D-MMMM-Y') }}
            </p>
            <a href="/admin/download" type="button" class="btn btn-warning my-3">Kembali</a>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection
