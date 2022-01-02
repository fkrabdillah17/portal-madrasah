@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    @if (session('sukses'))
        <div class="alert alert-success" id="success-alert" role="alert">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <h1 class="text-center shadow font-weight-bold text-dark">Beranda</h1>
    {{-- <div class="card border-primary shadow mb-3">
        <div class="card-header">Beranda</div>
        <div class="card-body" style="background-color: white">
            <h5 class="card-title">Light card title</h5>
            <p class="card-text">Selamat Datang di Menu Administrator Portal MTsN 1 Kota Bengkulu</p>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $user }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill text-primary" style="font-size: 2rem; "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jumlah Berita</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $news }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-newspaper text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Galeri</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $gallery }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-images text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Jumlah Unduhan</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $download }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-file-earmark-arrow-down text-secondary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
