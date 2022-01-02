@extends('layouts.admin.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Tambah Data Unduh</h1>
        <a href="/admin/service" type="button" class="btn btn-warning" id="backButton">Kembali</a>
    </div>

    {{-- Start Page Content --}}
    <div class="card col-8 mx-auto">
        <div class=" card-body">
            <form action="/admin/download" method="post" id="inputForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group" id="rowIsi">
                    <label for="title" id="labelIsi">Judul</label>
                    <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}">
                    @error('title')
                        <div id="validationTitle" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group" id="rowIsi">
                    <label for="file" id="labelIsi">File</label>
                    <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file"
                        value="{{ old('file') }}">
                    @error('file')
                        <div id="validationFile" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" id="button">Simpan</button>
            </form>
        </div>
    </div>
    {{-- End Page Content --}}

@endsection
