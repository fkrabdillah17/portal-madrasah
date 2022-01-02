@extends('layouts.user.main')

@section('content')
    <h1 class="text-center">Galeri Foto</h1>
    <hr>
    <div class="row">
        @foreach ($data as $d)
            <div class="col-4 my-2">
                <div class="card h-100 my-2">
                    <a href="{{ route('show-foto', $d->slug) }}" class="linkBerita">
                        <img src="{{ asset('assets/img/gallery/' . $d->file) }}" class="card-img-top" alt="..."
                            height="150px">
                    </a>

                    <div class="card-body">
                        <a href="{{ route('show-foto', $d->slug) }}" class="linkBerita">
                            <p class="card-text fw-bold text-uppercase">{!! \Illuminate\Support\Str::limit($d->title, 80, $end = '...') !!}</p>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- {{ $data->links() }} --}}
@endsection
