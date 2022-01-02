@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Kesiswaan</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="card mx-auto" style="width: 30rem;">
        <div class="card-header">
            {{ $kesiswaan->title }}
        </div>
        <div class="col mx-1">
            <div class="row">
                <i class="bi bi-tag-fill mx-1"> {{ $kesiswaan->category->name }}</i>
                <i class="bi bi-person-fill mx-1"> {{ $kesiswaan->createdBy->name }}</i>
            </div>
        </div>
        <div class="card-body">
            <P>{!! $kesiswaan->description !!} </P>
        </div>
        <div class="card-footer text--muted mx-auto text-center">
            <p>Di perbarui oleh {{ $kesiswaan->updatedBy->name }}</p>
            <p>Di Unggah pada {{ $kesiswaan->created_at->isoFormat('D-MMMM-Y') }}</p>
            <p>Di Update pada {{ $kesiswaan->updated_at->isoFormat('D-MMMM-Y') }}</p>
            <hr>
            <a href="{{ route('kesiswaan.index') }}" class="btn btn-warning mx-auto">Kembali</a>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
