@extends('layouts.admin.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Layanan</h1>
    </div>

    {{-- Start Page Content --}}
    <div class="card mx-auto" style="width: 40rem;">
        <div class="card-header font-weight-bold text-center">
            {{ $service->title }}
        </div>
        <div class="card-body">
            <P>{!! $service->content !!} </P>
        </div>
        <div class="card-footer text-center">
            <p>
                Di Unggah oleh {{ $service->createdBy->name }} pada {{ $service->created_at->isoFormat('D-MMMM-Y') }}
            </p>
            Di Update oleh {{ $service->updatedBy->name }} pada
            {{ $service->updated_at->isoFormat('D-MMMM-Y') }}
            <hr>
        </div>
        <a href="/admin/service" class="btn btn-warning mx-auto mb-3">Kembali</a>
    </div>
    {{-- End Page Content --}}
@endsection
