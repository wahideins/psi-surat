@extends('kelurahan.layoutsKelurahan')

@section('title')
Daftar Warga
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kelurahan/daftarWarga.css') }}">
@endpush

@section('content')

    <div class="judul">
        <h1>Daftar Warga</h1>
    </div>

    <div class="tabel-warga">

        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>RT</th>
                    <th>RW</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warga as $user)
                    <tr>
                        <td>{{ $user['nik'] ?? '-' }}</td>
                        <td>{{ $user['nama'] ?? '-' }}</td>
                        <td>{{ $user['email'] ?? '-' }}</td>
                        <td>{{ $user['rt'] ?? '-' }}</td>
                        <td>{{ $user['rw'] ?? '-' }}</td>
                        <td><a href="{{route('detailWarga', $user['uid'])}}">Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td>Tidak ada data warga</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
