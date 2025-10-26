@extends('warga.layouts.layoutsWarga')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/riwayatSurat.css') }}">
@endpush

@section('content')
<div class="header">
    <h2>Riwayat & Status Surat</h2>
</div>

<div class="main">
    @foreach($surat as $id => $item)
        <h3>{{ $item['kategori'] ?? 'Tidak diketahui' }}</h1>
        <p>{{ $item['tanggalPengajuan'] ?? '-' }}</p>
        <p>Status: {{ $item['status'] ?? '-' }}</p>
    @endforeach
</div>

@endsection