@extends('layouts.user.main')

@section('content')
    <h1 class="text-center">Data Monografi Desa Wonoharjo</h1>
    @foreach ($maintag as $m)
        <div class="card bg-light my-3" style="border: none">
            <div class="card border-dark py-1 my-1" style="border-radius: 25px">
                <span class="text-center fw-bolder">{{ $m->category }}</span>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($subtag as $s)
                    @if ($m->id == $s->category_id)
                        @foreach ($data as $d)
                            @if ($d->sub_category_id == $s->id)
                                <div class="col-6">
                                    <div class="card mx-auto h-100 my-2 border-dark" style="border-radius: 25px">
                                        <div class="card-header text-center">
                                            <span class="fw-bolder">{{ $d->sub_category->sub_category }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <P>{!! $d->content !!} </P>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
