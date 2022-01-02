@extends('layouts.admin.main')

@section('title', 'Ubah Data Galeri')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Galeri</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="row">
        <a href="/admin/gallery" type="button" class="btn btn-warning mb-auto">Kembali</a>
        <div class="card shadow col-8 mb-4 mx-auto">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data Galeri</h6>
            </div>
            <div class=" card-body">
                <form action="/admin/gallery/{{ $gallery->id }}" method="post" id="inputForm"
                    enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="tag">Kategori</label>
                        <select class="form-control @error('tag') is-invalid @enderror" id="tag" name="tag" disabled>
                            <option value="{{ $gallery->tag }}">{{ $gallery->tag }}</option>
                        </select>
                        <input type="hidden" id="tag" name="tag" value="{{ $gallery->tag }}">
                        @error('tag')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowTitle">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') ? old('title') : $gallery->title }}">
                        <input type="hidden" name="oldTitle" value="{{ $gallery->title }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowIsi">
                        <label for="editor" id="labelIsi">Caption</label>
                        <textarea class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                            value="{{ $gallery->content }}">{{ $gallery->content }}</textarea>
                        @error('editor')
                            <div id="validationEditor" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if ($gallery->tag == 'Video')
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ $gallery->file }}" allowfullscreen></iframe>
                        </div>
                        <div class="form-group" id="rowLink">
                            <label for="video" id="labelIsi">Link Video Youtube</label>
                            <input type="text" class="form-control @error('video') is-invalid @enderror" id="video"
                                name="video" value="{{ $gallery->file }}" readonly>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Isi kolom dengan link video yang sudah di unggah di <i class="bi bi-youtube">Youtube</i>
                            </small>
                            @error('video')
                                <div id="validationVideo" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @else
                        <div class="form-group">
                            <label for="photo">Foto Lama</label>
                            <img src="{{ asset('assets/img/gallery/' . $gallery->file) }}" width="100%" alt="">
                        </div>
                        <div class="form-group" id="rowFile">
                            <label for="file" id="labelIsi">File</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file"
                                name="file" value="{{ old('file') }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Ukuran Maksimal Foto 2 Mb.
                            </small>
                            @error('file')
                                <div id="validationFile" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary" id="tombol">Simpan</button>
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
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
