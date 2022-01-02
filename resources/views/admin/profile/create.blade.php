@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Profil</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="row">
        <a href="/admin/profile" type="button" class="btn btn-warning mb-3 mb-auto">Kembali</a>
        <div class="card shadow col-8 mb-4 mx-auto">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Profil</h6>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/profile" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="tag">Kategori</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#staticBackdrop">
                                    +
                                </button>
                            </div>
                            <select class="custom-select @error('tag') is-invalid @enderror" id="tag" name="tag">
                                <option value="{{ old('tag') }}">{{ old('tag') ? old('tag') : '-Pilihan-' }} </option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <div class="form-group">
                        <label for="opsi">Opsi Konten</label>
                        <select class="form-control @error('opsi') is-invalid @enderror" id="opsi" name="opsi"
                            onchange="option()">
                            <option value="Deskripsi">Deskripsi</option>
                            <option value="File">File Gambar</option>
                        </select>
                        @error('opsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowContent">

                    </div>
                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('profile.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group" id="rowTitle">
                            <label for="name">Kategori</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- @section('ck-editor')
    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection --}}

@section('javascript')
    <script type="text/javascript">
        window.onload = function() {
            let kategori = document.getElementById('opsi').value;
            option();
        }

        function option() {
            let kategori = document.getElementById('opsi').value;
            let replaceContent = document.getElementById('rowContent');
            if (kategori == "Deskripsi") {
                replaceContent.innerHTML =
                    `<label for="content ">Isi</label> <textarea type="text" class = "form-control @error('editor') is-invalid @enderror" id = "editor" name="editor" value="{{ old('editor') }}"> {{ old('editor') }} </textarea>
                        @error('editor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror`;
                ClassicEditor
                    .create(document.querySelector('#editor'))
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else if (kategori == "File") {
                replaceContent.innerHTML =
                    `<input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Ukuran File Maksimal 2 Mb. Rekomendasi Dimensi File 1930x930 px. Extensi File JPG, JPEG atau PNG 
                        </small>
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror`;
            }
        }
    </script>
@endsection
