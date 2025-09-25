@extends('layouts.index')

@section('title', 'SIMARSU')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landingpages.css') }}">
@endpush


@section('navbar')
<div class="navbar">
    <div class="logo" id="logoToggle">
        <img src="{{asset('img/logo.png')}}" alt="">
    </div>

    <div class="nav-link" id="navLink">
        <a href="">Beranda</a>
        <a href="">Profil</a>
        <a href="">Pelayanan</a>
        <a href="">Kontak</a>
        <a href="{{url('/login')}}">Login</a>
    </div>

</div>
@endsection

@section('main')

<div class="hero">

    <div class="frasa">
        <h1>Pelayanan Surat Menyurat <br> Kelurahan Sukorame</h1>
        <div class="btn-daftar">
            <a href="#">Daftar</a>
        </div>
    </div>

</div>

<div class="hero-1">

    <div class="header">
        <h1 style="color:black;">Visi & Misi</h1>
    </div>

    <div class="content">

        <div class="visi">
            <div class="header">
                <h1 style="color:black;">Visi</h1>
            </div>
            <div class="deskripsi">
                <p>
                    “Pelayanan Prima untuk meningkatkan pemberdayaan masyarakat demi terciptanya kesejahteraan”
                </p>
            </div>
        </div>

        <div class="misi">
            <div class="header">
                <h1 style="color:black;">Misi</h1>
            </div>

            <div class="misi-deskripsi">
                <ol>
                    <li>Meningkatkan kedudukan,peran dan fungsi kelurahan dalam pelaksanaan administrasi pemerintahan dan pelayanan publik</li>
                    <li>Meningkatkan kualitas penyajian informasi kepada masyarakat tentang penyelenggaraan pelayanan publik di tingkat kelurahan</li>
                    <li>Meningkatkan partisipasi masyarakat dalam proses perencanaan pembangunan di tingkat kelurahan</li>
                    <li>Menigkatkan pembangunan sesuai dengan potensi dan tipologi kawasan kelurahan
                    <li>Meningkatkan kualitas kehidupan sosial masyarakat melalui pengembangan seni budaya dan organisasi kemasyarakatan</li>
                    <li>Meningkatkan taraf kehidupan masyarakat melalui pembinaan ketrampilan dan UKM</li>
                </ol>
            </div>
        </div>

    </div>



</div>

<script src="{{asset('js/landingpages.js')}}"></script>

@endsection

