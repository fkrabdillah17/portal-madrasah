@extends('layouts.admin.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Data Profil</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Start Page Content --}}
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Detail {{ $profile->title }}
        </div>
        <div class="card-body">
            @if ($profile->opsi != 'File')
                <P>{!! $profile->content !!}</P>
            @else
                <P class="align-item-center"><img src="{{ asset('assets/img/profile/' . $profile->content) }}" width="100%"
                        height="100%" alt="">
                </P>
            @endif
        </div>
        <div class="card-footer text--muted mx-auto text-center">
            <p>
                Di Unggah oleh {{ $profile->createBy->name }} pada {{ $profile->created_at->isoFormat('D-MMMM-Y') }}
            </p>
            Di Update oleh {{ $profile->updateBy->name }} pada
            {{ $profile->updated_at->isoFormat('D-MMMM-Y') }}
            <hr>
            <a href="{{ route('profile.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
    {{-- End Page Content --}}
@endsection
