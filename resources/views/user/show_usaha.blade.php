@extends('layouts.user.main')

@section('content')
    <div class="card my-2 shadow" style="width: 830px;">
        <img src="{{ asset('assets/img/business/' . $data->thumbnail) }}" class="card-img-top" alt="Thumbnail"
            height="400px">
        <div class="card-body">
            <h5 class="card-title">{{ $data->title }}</h5>
            <p class="card-text">
                <small class="text-muted">
                    {{ $data->tag }} - {{ $data->category }} - {{ $data->field }}
                </small>
            </p>
            <h5>Data Umum</h5>
            <table class="table table-borderless table-sm">
                <thead>
                    <tr>
                        <th class="col-3"></th>
                        <th class="col-1"></th>
                        <th class="col-auto"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pemilik Usaha</td>
                        <td>:</td>
                        <td>{{ $data->tag }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Usaha</td>
                        <td>:</td>
                        <td>{{ $data->category }}</td>
                    </tr>
                    <tr>
                        <td>Bidang Usaha</td>
                        <td>:</td>
                        <td>{{ $data->field }}</td>
                    </tr>
                    <tr>
                        <td>Nama Usaha</td>
                        <td>:</td>
                        <td>{{ $data->title }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Usaha</td>
                        <td>:</td>
                        <td>{{ $data->address }}</td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-whatsapp"></i>Whatsapp</td>
                        <td>:</td>
                        <td>+62{{ $data->whatsapp }}</td>
                    </tr>
                    @if ($data->instagram != '-')
                        <tr>
                            <td><i class="bi bi-instagram"></i>Instagram</td>
                            <td>:</td>
                            <td><span>@</span>{{ $data->instagram }}</td>
                        </tr>
                    @endif
                    @if ($data->facebook != '-')
                        <tr>
                            <td><i class="bi bi-facebook"></i>Facebook</td>
                            <td>:</td>
                            <td><span>@</span>{{ $data->facebook }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <p class="card-text">{!! $data->description !!}</p>
        </div>
    </div>
@endsection
