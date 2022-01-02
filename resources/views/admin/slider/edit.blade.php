@extends('layouts.admin.main')

@section('title', 'Slider')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Slide</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="row">
        <a href="{{ route('slide.index') }}" type="button" class="btn btn-warning mb-auto">Kembali</a>
        <div class="card shadow col-8 mb-4 mx-auto">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data Slide</h6>
            </div>
            <div class=" card-body">
                <form action="{{ route('slide.update', $information->id) }}" method="post" id="inputForm"
                    enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="title">Kategori</label>
                        <select class="form-control @error('title') is-invalid @enderror" id="title" name="title" readonly>
                            <option value=" {{ $information->title }}">{{ $information->title }} </option>
                        </select>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Lama</label>
                        <img src="{{ asset('assets/img/slider/' . $information->file) }}" width="100%" alt="">
                    </div>
                    <div class="form-group" id="rowFile">
                        <label for="file" id="labelIsi">File</label>
                        <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file"
                            name="file" value="{{ old('file') }}">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Ukuran File Maksimal 2 Mb. Rekomendasi Dimensi FIle 1930x930 px
                        </small>
                        @error('file')
                            <div id="validationFile" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" id="tombol">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
