@extends('layouts.user.main')

@section('content')
    <div class="card my-3 shadow">
        <div class="row g-0">
            <h5 class="text-center">{{ $data->title }}</h5>
            <small class="text-muted text-center mb-2">
                Di unggah {{ $data->updated_at->isoFormat('D-MMMM-Y') }} oleh {{ $data->createdBy->name }}
            </small>
            <div class="ratio ratio-16x9">
                <iframe src="/assets/files/{{ $data->file }}" title="{{ $data->title }}" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection
