@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Profil Desa</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="row">
        <a href="{{ route('profile.index') }}" type="button" class="btn btn-warning mb-3 mb-auto">Kembali</a>
        <div class="card shadow col-8 mb-4 mx-auto">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data Profil</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update', $profile->id) }}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="tag">Kategori</label>
                        <select class="form-control @error('tag') is-invalid @enderror" id="tag" onchange="option()"
                            name="tag" disabled>
                            <option value="{{ $profile->tag }}">{{ $profile->category->name }} </option>
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
                            name="title" value="{{ $profile->title }}">
                        <input type="hidden" name="oldTitle" value="{{ $profile->title }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="opsi">Opsi Konten</label>
                        <select class="form-control @error('opsi') is-invalid @enderror" id="opsi" name="opsi"
                            onchange="option()" readonly>
                            <option value="{{ $profile->opsi }}">{{ $profile->opsi }}</option>
                        </select>
                        @error('opsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if ($profile->opsi != 'Deskripsi')
                        <div class="form-group">
                            <label for="photo">Foto Lama</label>
                            <img src="{{ asset('assets/img/profile/' . $profile->content) }}" width="100%" alt="">
                        </div>
                    @endif
                    <div class="form-group" id="rowContent">
                    </div>
                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                </form>
            </div>
        </div>
        {{-- End Page Content --}}
    @endsection

    @section('javascript')
        <script type="text/javascript">
            window.onload = function() {
                option();
            }

            function option() {
                let kategori = document.getElementById('opsi').value;
                let replaceContent = document.getElementById('rowContent');
                if (kategori != "File") {
                    replaceContent.innerHTML =
                        `<label for="content ">Isi</label> <textarea type="text" class = "form-control @error('editor') is-invalid @enderror" id = "editor" name="editor" {{ $profile->content }}>{!! $profile->content !!} </textarea>
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
                } else {
                    replaceContent.innerHTML =
                        `<input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file">
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror`;
                }
            }
        </script>
    @endsection
