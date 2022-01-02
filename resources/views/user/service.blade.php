@extends('layouts.user.main')

@section('content')
    <div class="card shadow bg-light my-3" style="border-radius: 25px; padding: 25px">
        @foreach ($content as $item)
            <h1 class="text-center">{{ $item->title }}</h1>
            <p>{!! $item->content !!}</p>
        @endforeach
    </div>
@endsection
