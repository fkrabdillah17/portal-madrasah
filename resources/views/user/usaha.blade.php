@extends('layouts.user.main')

@section('content')
    @foreach ($data as $d)
        @php
            $excerpt = substr($d->description, 0, 300);
        @endphp
        <div class="card my-2 shadow" style="width: 830px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('assets/img/business/' . $d->thumbnail) }}" class="img-fluid rounded-start"
                        alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $d->title }}</h5>
                        <p class="card-text">
                            <small class="text-muted">
                                {{ $d->tag }} - {{ $d->category }} - {{ $d->field }}
                            </small>
                        </p>
                        <p class="card-text">{!! $excerpt !!}...</p>
                        <a href="{{ route('show-usaha-desa', $d->slug) }}"
                            class="btn btn-primary position-absolute bottom-0 end-0"><i class="bi bi-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{ $data->onEachSide(1)->links() }}
@endsection
