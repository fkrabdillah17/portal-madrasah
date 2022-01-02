@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Galeri</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Galeri</h6>
            </div>
            <div class=" card-body">
                <form action="/admin/gallery" method="post" id="inputForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="tag">Kategori</label>
                        <select class="form-control @error('tag') is-invalid @enderror" id="tag" name="tag"
                            onchange="option()">
                            <option value="{{ old('tag') }}">{{ old('tag') ? old('tag') : '-Pilihan-' }} </option>
                            <option value="Foto">Foto</option>
                            <option value="Video">Video</option>
                        </select>
                        @error('tag')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowTitle">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowIsi">
                        <label for="editor" id="labelIsi">Caption</label>
                        <textarea class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                            value="{{ old('editor') }}">{{ old('editor') }}</textarea>
                        @error('editor')
                            <div id="validationEditor" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowLink">

                    </div>
                    <div class="form-group" id="rowFile" style="display: none">
                        <label for="image" id="labelIsi">File</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                            name="images[]" value=" {{ old('image') }}" accept="image/*" multiple>
                        <small class="form-text text-muted">
                            Ukuran Maksimal Foto 2 Mb.
                        </small>
                        @error('image')
                            <div id="validationFile" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" id="tombol" style="display: none">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection

@section('javascript')
    <script>
        window.onload = function() {
            let kategori = document.getElementById('tag').value;
            if (kategori == "Video" || kategori == "Foto") {
                option();
            }
        }

        function option() {
            let option = document.getElementById('tag').value;
            let file = document.getElementById('rowFile');
            let link = document.getElementById('rowLink');
            let button = document.getElementById('tombol');
            if (option == "Foto") {
                button.style.display = "";
                file.style.display = "";
                link.innerHTML = "";
            } else if (option == "Video") {
                button.style.display = "";
                file.style.display = "none";
                link.innerHTML = `
                <label for="video" id="labelIsi">Link Video Youtube</label>
                        <input type="text" class="form-control @error('video') is-invalid @enderror" id="video"
                            name="video" value="{{ old('video') }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                        Isi kolom dengan link video yang sudah di unggah di <i class="bi bi-youtube">Youtube</i> 
                    </small>
                        @error('video')
                            <div id="validationVideo" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                `;
            } else {
                button.style.display = "none";
                file.style.display = "none";
                link.innerHTML = "";
            }
        }
    </script>
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
