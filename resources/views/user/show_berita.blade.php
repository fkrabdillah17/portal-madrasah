@extends('layouts.user.main')

@section('content')
    <div class="card my-2 shadow">
        <img src="{{ asset('assets/img/news/' . $data->thumbnail) }}" class="card-img-top" alt="Thumbnail">
        <div class="card-body">
            <h5 class="card-title">{{ $data->title }}</h5>
            <p class="card-text">
                <small class="text-muted">
                    {{ $data->updated_at->isoFormat('D-MMMM-Y') }} ~ Di Tulis Oleh {{ $data->createBy->name }} ~
                    <i class="bi bi-bookmark-dash-fill"
                        style="color: rgb(39, 28, 192)">{{ $data->newsCategory->category }}</i>
                </small>
            </p>
            <p class="card-text">{!! $data->content !!}</p>
        </div>
    </div>
@endsection
