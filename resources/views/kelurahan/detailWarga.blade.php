@extends('kelurahan.layoutsKelurahan')

@section('title')
Detail Warga
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/kelurahan/detailWarga.css') }}">
@endpush
@section('content')

    <div class="judul">
        <h1>{{ isset($warga['nama']) ? 'Detail Warga' : 'Daftar Warga' }}</h1>

        <div class="breadcrumb">
            <a href="{{ route('daftarWarga') }}">Daftar Warga</a>

            @if(isset($warga['nama']))
                <span>&gt;</span>
                <strong>{{ $warga['nama'] }}</strong>
            @endif
        </div>
    </div>

<div class="biodata-warga"></div>

<div class="detail-warga">
  <div class="item-warga">Biodata {{$warga['nama'] ?? '-'}}</div>
  <div class="item-warga">
    <p class="nik">NIK</p>
    <p>Nama</p>
    <p>TTL</p>
    <p>Jenis Kelamin</p>
    <p>Alamat</p>
    <p class="detail-alamat">RT/RW</p>
    <p class="detail-alamat">Kel/Desa</p>
    <p class="detail-alamat">Kecamatan</p>
    <p>Agama</p>
    <p>Status Perkawinan</p>
    <p>Status Dalam Keluarga</p>
    <p>Pekerjaan</p>
  </div>
  <div class="item-warga">
    <p class="nik">: {{ $warga['nik'] ?? '-'}} </p>
    <p>: {{ $warga['nama'] ?? '-'}} </p>
    <p>: {{ $warga['tempatLahir'] ?? '-'}} / {{ $warga['tanggalLahir'] ?? '-'}} </p>
    <p>: {{ $warga['jenisKelamin'] ?? '-'}} </p>
    <p>: {{ $warga['alamat'] ?? '-'}} </p>
    <p>: {{ $warga['rt'] }}/{{ $warga['rw'] ?? '-'}} </p>
    <p>: {{ $warga['kelurahan'] ?? '-'}} </p>
    <p>: {{ $warga['kecamatan'] ?? '-'}} </p>
    <p>: {{ $warga['agama'] ?? '-'}} </p>
    <p>: {{ $warga['statusPerkawinan'] ?? '-'}} </p>
    <p>: {{ $warga['statusDiKeluarga'] ?? '-'}} </p>
    <p>: {{ $warga['pekerjaan'] ?? '-'}} </p>
  </div>
</div>

<div class="dokumen">
  <div class="judul">
    <h1>KTP/KK</h1>
  </div>
  <img src="{{$warga['urlFotoKtp']}}" alt="Foto KTP">
  <img src="{{$warga['urlFotoKk']}}" alt="Foto KTP">
</div>

<div class="judul">
  <h1>Daftar Keluarga {{$warga['nama']?? '-'}}</h1>
</div>
@endsection
