@extends('layouts.admin.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Layanan</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="row">
        <a href="{{ route('kesiswaan.index') }}" type="button" class="btn btn-warning mb-3 mb-auto">Kembali</a>
        <div class="card shadow col-9 mx-auto">
            <div class=" card-body">
                <form action="/admin/service" method="post" id="inputForm" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label for="opsi">Opsi Konten</label>
                        <select class="form-control @error('opsi') is-invalid @enderror" id="opsi" name="opsi"
                            onchange="option()">
                            <option value="Deskripsi">Deskripsi</option>
                            <option value="Link">Link</option>
                        </select>
                        @error('opsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowinput">
                        <label for="editor" id="labelIsi">Isi</label>
                        <textarea class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                            value="{{ old('editor') }}">{{ old('editor') }}</textarea>
                        @error('editor')
                            <div id="validationIsi" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" id="button">Simpan</button>
                </form>
            </div>
        </div>
    </div>
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
                <form method="post" action="{{ route('service.categories.store') }}" enctype="multipart/form-data">
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
    {{-- End Page Content --}}
@endsection

@section('javascript')
    <script type="text/javascript">
        window.onload = function() {
            option();
        }

        function option() {
            let opsi = document.getElementById('opsi').value;
            let replaceContent = document.getElementById('rowinput');
            if (opsi == "Link") {
                replaceContent.innerHTML =
                    `<label for="content ">Link</label> <textarea type="text"
                class="form-control @error('editor') is-invalid @enderror" id="link" name="editor"
                value="{{ old('editor') }}"> {{ old('editor') }} </textarea>
                @error('editor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror`;
            } else {
                replaceContent.innerHTML =
                    `<label for="content ">Deskripsi</label> <textarea type="text"
                        class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                        value="{{ old('editor') }}"> {{ old('editor') }} </textarea>
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
            }

        }
    </script>
@endsection

@section('ck-editor')
    <script>

    </script>
@endsection
