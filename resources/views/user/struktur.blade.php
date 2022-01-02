@extends('layouts.user.main')

@section('content')
    <div class="card shadow bg-light my-3" style="border-radius: 25px; padding:10px">
        @foreach ($data as $item)
            <h1 class="text-center">{{ $item->title }}</h1>
            <img src="{{ asset('assets/img/profile/' . $item->content) }}" alt="" srcset="" style="border-radius: 10px">
        @endforeach
    </div>
@endsection
