@extends('layouts.user.main')

@section('content')
    <h1 class="text-center text-break text-uppercase">{{ $album }}</h1>
    <h6 class="text-center text-break">{!! $content !!}</h6>
    <hr>
    <div class="row">
        @foreach ($data as $d)
            <div class="my-2 ">
                <img src="{{ asset('assets/img/gallery/' . $d->file) }}" class="card-img-top" alt="..." height="400px">
            </div>
        @endforeach
    </div>
@endsection
