@extends('layouts.user.main')

@section('content')
    <div class="card shadow bg-light my-3" style="border-radius: 25px; padding: 25px">
        @foreach ($data as $item)
            @if ($item->opsi == 'Deskripsi')
                <article class="mx-auto">
                    <h1 class="text-center">{{ $item->title }}</h1>
                    <p>{!! $item->content !!}</p>
                </article>
            @else
                <h1 class="text-center">{{ $item->title }}</h1>
                <img src="{{ asset('assets/img/profile/' . $item->content) }}" alt="" srcset=""
                    style="border-radius: 10px">
            @endif
        @endforeach
    </div>
@endsection
