@extends('layouts.admin.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kesiswaan</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <a href="{{ route('kesiswaan.create') }}" type="button" class="btn btn-primary mb-3">Tambah Data</a>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger mb-3 float-right" data-toggle="modal" data-target="#staticBackdrop">
        Hapus Kategori
    </button>
    {{-- <a href="{{ route('category.index') }}" type="button" class="btn btn-warning mb-3">Tambah Kategori</a> --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Kesiswaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-0 text-center px-1"></th>
                            <th class="col-2">Kategori</th>
                            <th class="col-7">Judul</th>
                            <th class="col-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kesiswaan as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{!! $item->title !!}</td>
                                <td class="text-center">
                                    <a href="{{ route('kesiswaan.show', $item->id) }}" type="button"
                                        class="btn btn-primary my-1 rounded" data-toggle="tooltip" data-placement="top"
                                        title="Detail Data"><i class="fas fa-info-circle"></i></a>
                                    <a href="{{ route('kesiswaan.edit', $item->id) }}" type="button"
                                        class="btn btn-warning my-1 rounded " data-toggle="tooltip" data-placement="top"
                                        title="Edit Data"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('kesiswaan.destroy', $item->id) }}" class="d-inline"
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

    {{-- Modal --}}
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Hapus Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="rowTitle">
                        @foreach ($category as $item)
                            <div class="col">
                                <label for="name">{{ $item->name }}</label>
                                <form action="{{ route('kesiswaan.categories.destroy', $item->id) }}"
                                    class="d-inline" method="post"
                                    onsubmit="return confirm('Apakah Anda Yakin Menghapus Semua Data {{ $item->name }} ?')">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger my-1 rounded" data-toggle="tooltip" data-placement="top"
                                        title="Hapus Data"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
