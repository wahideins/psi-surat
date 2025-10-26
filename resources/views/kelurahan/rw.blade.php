@extends('kelurahan.layoutsKelurahan')

@section('title')
Daftar RW Aktif
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kelurahan/daftarWarga.css') }}">
@endpush

@section('content')

    <div class="judul">
        <h1>Daftar RW Aktif</h1>
    </div>

    <div class="daftar-rt">
        @forelse($rtAktif as $user)
            <h1>RW {{ $user['nomor_rw'] }}:  <a href="{{route('detailWarga', $user['uid'])}}">{{ $user['nama'] }}</a></h1>
        @empty
            <h1>Tidak Ada RW Aktif</h1>
        @endforelse
    </div>

@endsection
