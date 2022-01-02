@extends('layouts.user.main')

@section('content')
    <h1 class="text-center">Galeri Video</h1>
    <hr>

    <div class="card-group">
        @foreach ($data as $v)
            <div class="col-md-6 col-sm-6 col-xs-12 my-3">
                <div class="card  h-100 mx-2 shadow" style="border-radius: 30px">
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="{{ $v->file }}" allowfullscreen></iframe>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $v->title }}</h5>
                        <p class="card-text">{!! \Illuminate\Support\Str::limit($v->content, 200, $end = '...') !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $data->onEachSide(1)->links() }}
@endsection
