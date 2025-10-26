@extends('kelurahan.layoutsKelurahan')

@section('title')
Dashboard Kelurahan
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/dashboard.css') }}">
@endpush

@section('content')
<div class="header">
    <p>Selamat Datang</p>
    <h2>{{ $biodata['nama']?? '-' }} </h2>
</div>

<div class="judul">
    <h1>Dashboard Kelurahan</h1>
</div>

<div class="main">
    
</div>
@endsection