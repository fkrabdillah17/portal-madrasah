@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Tenaga Kependidikan</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="card mx-auto" style="width: 30rem;">
        <img src="{{ asset('assets/img/staff/' . ($staff->photo != null ? $staff->photo : 'person2.svg')) }}"
            class="card-image-top mx-auto d-block" width="250px" height="300px" alt="">
        <div class="card-header text-center">
            {{ $staff->name }}
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <td class="col-3">NIP</td>
                    <td class="col-1">:</td>
                    <td class="col-8">{!! $staff->nip !!} </td>
                </tr>
                <tr>
                    <td class="col-3">Jenis GTK</td>
                    <td class="col-1">:</td>
                    <td class="col-8">{!! $staff->jabatan !!} </td>
                </tr>
            </table>
        </div>
        <div class="card-footer text--muted mx-auto text-center">
            <p>Di Unggah Oleh {{ $staff->createdBy->name }} pada
                {{ $staff->created_at->isoFormat('D-MMMM-Y') }}</p>
            <p>Di Update Oleh {{ $staff->createdBy->name }} pada {{ $staff->updated_at->isoFormat('D-MMMM-Y') }}
            </p>
            <hr>
            <a href="{{ route('staff.index') }}" class="btn btn-warning mx-auto">Kembali</a>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
