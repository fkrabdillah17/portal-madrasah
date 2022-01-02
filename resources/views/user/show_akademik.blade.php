@extends('layouts.user.main')

@section('content')
    @foreach ($data as $item)
        <div class="card my-3 shadow">
            <img src="{{ asset('assets/img/academic/' . $item->file) }}" class="card-img-top" alt="Thumbnail"
                height="400px">
            <div class="card-body">
                <h5 class="card-title">{{ $item->title }}</h5>
                <p class="card-text">
                    <small class="text-muted">
                        {{ $item->updated_at->isoFormat('D-MMMM-Y') }} ~ Di Tulis Oleh {{ $item->createdBy->name }} ~
                    </small>
                </p>
                <p class="card-text">{!! $item->description !!}</p>
            </div>
        </div>
    @endforeach

@endsection
