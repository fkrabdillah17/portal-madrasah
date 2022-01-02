@extends('layouts.admin.main')

@section('title', 'Pengguna')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- Start Page Content --}}
        <a href="/admin/account/create" type="button" class="btn btn-primary mb-3">Tambah Data</a>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Data Pengguna</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-1 text-center"></th>
                                <th class="col-4">Nama</th>
                                <th class="col-4">Email</th>
                                <th class="col-2">Status</th>
                                <th class="col-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->email_verified_at != null ? 'Aktif' : 'Email Belum Terverifikasi' }}
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="/admin/account/{{ $item->slug }}/edit" type="button"
                                            class="btn btn-success my-1 rounded " data-toggle="tooltip" data-placement="top"
                                            title="Edit Data"><i class="fas fa-edit"></i></a> --}}
                                        <form action="/admin/account/{{ $item->id }}" class="d-inline"
                                            method="post" onsubmit="return confirm('Apakah Anda Yakin Menghapus Data?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger my-1 rounded" data-toggle="tooltip"
                                                data-placement="top" title="Hapus Data"><i
                                                    class="fas fa-trash"></i></button>
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
