@extends('layouts.user.main')

@section('content')
    <div class="row mb-3 pt-3 justify-content-md-center">
        @foreach ($data as $d)
            <div class="card mb-3 shadow mx-1" style="max-width: 440px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset('assets/img/staff/' . $d->photo) }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $d->name }}</h5>
                            <table>
                                <tr>
                                    <td class="fw-bold">NIP</td>
                                    <td> </td>
                                    <td>{{ $d->nip }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jenis GTK</td>
                                    <td> </td>
                                    <td>{{ $d->jabatan }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
