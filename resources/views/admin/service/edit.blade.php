@extends('layouts.admin.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Ubah Data Layanan</h1>
        <a href="/admin/service" type="button" class="btn btn-warning" id="backButton">Kembali</a>
    </div>

    {{-- Start Page Content --}}
    <div class="card col-8 mx-auto">
        <div class=" card-body">
            <form action="/admin/service/{{ $service->slug }}" method="post" id="inputForm">
                @method('patch')
                @csrf
                <div class="form-group" id="rowIsi">
                    <label for="title" id="labelIsi">Judul</label>
                    <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ $service->title }}">
                    <input type="hidden" id="oldTitle" name="oldTitle" value="{{ $service->title }}">
                    @error('title')
                        <div id="validationTitle" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if ($service->opsi == 'Deskripsi')
                    <div class="form-group" id="rowIsi">
                        <label for="editor" id="labelIsi">Deskripsi</label>
                        <textarea class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                            value="{{ $service->content }}">{{ $service->content }}</textarea>
                        @error('editor')
                            <div id="validationIsi" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @else
                    <div class="form-group" id="rowIsi">
                        <label for="editor" id="labelIsi">Link</label>
                        <textarea class="form-control @error('editor') is-invalid @enderror" id="link" name="editor"
                            value="{{ $service->content }}">{{ $service->content }}</textarea>
                        @error('editor')
                            <div id="validationIsi" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
                <button type="submit" class="btn btn-primary" id="button">Simpan</button>
            </form>
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
