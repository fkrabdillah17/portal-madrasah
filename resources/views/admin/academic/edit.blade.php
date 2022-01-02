@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Akademik</h1>
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
    <div class="row">
        <a href="{{ route('academic.index') }}" type="button" class="btn btn-warning mb-3 mb-auto">Kembali</a>
        <div class="card shadow col-8 mb-4 mx-auto">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data Berita</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('academic.update', $academic->id) }}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="tag">Kategori</label>
                        <select class="form-control @error('tag') is-invalid @enderror" id="tag" disabled>
                            <option value="{{ $academic->tag }}">{{ $kategori }}</option>
                        </select>
                    </div>
                    <div class="form-group" id="rowTitle">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') ? old('title') : $academic->title }}">
                        <input type="hidden" name="oldTitle" value="{{ $academic->title }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowContent">
                        <label for="content ">Deskripsi</label>
                        <textarea type="text" class="form-control @error('editor') is-invalid @enderror" id="editor"
                            name="editor"> {{ old('editor') ? old('editor') : $academic->description }}</textarea>
                        @error('editor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Lama</label>
                        <img src="{{ asset('assets/img/academic/' . $academic->file) }}" width="100%" alt="">
                    </div>
                    <div class="form-group" id="rowContent">
                        <label for="file ">Foto</label>
                        <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file"
                            name="file" id="customFileLang" lang="es">
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection

@section('ck-editor')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
