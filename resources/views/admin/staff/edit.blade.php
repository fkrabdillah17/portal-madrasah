@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Tenaga Kependidikan</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="row">
        <a href="{{ route('staff.index') }}" type="button" class="btn btn-warning mb-3 mb-auto">Kembali</a>
        <div class="card shadow col-8 mb-4 mx-auto">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data Tenaga Kependidikan</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('staff.update', $staff->id) }}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="tag">Kategori</label>
                        <div class="input-group mb-3">
                            <select class="custom-select @error('tag') is-invalid @enderror" id="tag" name="tag" readonly>
                                <option value="{{ $staff->staffCategory->name }}">
                                    {{ $staff->category ? $staff->staffCategory->name : '-Pilihan-' }} </option>
                            </select>
                        </div>
                        @error('tag')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowTitle">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') ? old('name') : $staff->name }}">
                        <input type="hidden" name="oldName" value="{{ $staff->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowTitle">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control  @error('nip') is-invalid @enderror" id="nip" name="nip"
                            value="{{ old('nip') ? old('nip') : $staff->nip }}">
                        @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group" id="rowTitle">
                        <label for="gtk">Jenis GTK</label>
                        <input type="text" class="form-control  @error('gtk') is-invalid @enderror" id="gtk" name="gtk"
                            value="{{ old('gtk') ? old('gtk') : $staff->jabatan }}">
                        @error('gtk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Lama</label>
                        @if ($staff->photo != null)
                            <img src="{{ asset('assets/img/staff/' . $staff->photo) }}" width="100%" alt="">
                            <input type="hidden" name="oldPhoto" value="{{ $staff->photo }}">
                        @else
                            <div>
                                <p class="text-center">Foto Tidak Ada</p>
                            </div>
                        @endif
                    </div>
                    <div class="form-group" id="rowContent">
                        <label for="photo ">Foto</label>
                        <input type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photo"
                            name="photo">
                        @error('photo')
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
