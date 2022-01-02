@extends('layouts.admin.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Unggah File Akademik</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="d-flex justify-content-between">
        <a href="{{ route('academic.index') }}" type="button" class="btn btn-warning mb-3 mb-3">Kembali</a>
        <a href="{{ route('academic.upload.create') }}" type="button" class="btn btn-primary mb-3">Tambah Data</a>
    </div>
    {{-- <a href="{{ route('category.index') }}" type="button" class="btn btn-warning mb-3">Tambah Kategori</a> --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Unggah File</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-0 text-center px-1"></th>
                            <th class="col-3">Judul</th>
                            <th class="col-6">URL</th>
                            <th class="col-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($academic as $item)
                            @php
                                $mounth = $item->created_at->isoFormat('M');
                                $year = $item->created_at->isoFormat('Y');
                                $slug = $item->slug;
                                $FileUpload = $item->id;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{!! $item->title !!}</td>
                                <td>{{ url('/') }}/content/academic/upload/{{ $item->id }}/{{ $mounth }}/{{ $year }}/{{ $slug }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('academic.upload.show', [$FileUpload, $mounth, $year, $slug]) }}"
                                        type="button" class="btn btn-primary my-1 rounded" data-toggle="tooltip"
                                        data-placement="top" title="Detail Data" target="__blank"><i
                                            class="fas fa-info-circle"></i></a>
                                    <form action="{{ route('academic.upload.destroy', $item->id) }}"
                                        class="d-inline" method="post"
                                        onsubmit="return confirm('Apakah Anda Yakin Menghapus Data?')">
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
