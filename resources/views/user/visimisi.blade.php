@extends('layouts.user.main')

@section('content')
    <div class="card shadow bg-light my-3" style="border-radius: 25px; padding: 25px">
        @foreach ($data as $item)
            <article class="mx-auto">
                <h1 class="text-center">{{ $item->title }}</h1>
                <p>{!! $item->content !!}</p>
            </article>
        @endforeach
    </div>
@endsection
