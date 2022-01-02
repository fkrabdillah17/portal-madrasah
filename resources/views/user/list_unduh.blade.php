@extends('layouts.user.main')

@section('content')
    @foreach ($data as $d)
        <div class="card my-3 shadow">
            <div class="row g-0">
                <div class="col-md-7">
                    <div class="card-body">
                        <a href="{{ route('show-unduh', $d->slug) }}" class="linkBerita">
                            <h5 class="card-title text-uppercase fw-bold">{{ $d->title }}</h5>
                        </a>
                        <p class="card-text">
                            <small class="text-muted">
                                Di unggah {{ $d->updated_at->diffForHumans() }} oleh {{ $d->createdBy->name }}
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{ $data->onEachSide(1)->links() }}
@endsection
