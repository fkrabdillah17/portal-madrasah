@extends('layouts.admin.main')

@section('content')


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Unduh MTsN 1 Kota Bengkulu</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <a href="/admin/download/create" type="button" class="btn btn-primary mb-3">Tambah Data</a>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Unduh MTsN 1 Kota Bengkulu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-0 text-center px-1"></th>
                            <th class="col-2">Tangal Unggah</th>
                            <th class="col-8">Judul</th>
                            <th class="col-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($downloads as $download)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $download->created_at->format('d-m-Y') }}</td>
                                <td>{{ $download->title }}</td>
                                <td class="text-center">
                                    <a href="/admin/download/{{ $download->id }}" type="button"
                                        class="btn btn-primary my-1 rounded" data-toggle="tooltip" data-placement="top"
                                        title="Detail Data"><i class="fas fa-info-circle"></i></a>
                                    <form action="/admin/download/{{ $download->id }}" class="d-inline"
                                        method="post" onsubmit="return confirm('Apakah Anda Yakin Menghapus Data?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger my-1 rounded" data-toggle="tooltip"
                                            data-placement="top" title="Hapus Data"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}

@endsection
