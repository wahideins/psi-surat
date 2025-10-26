@extends('warga.layouts.layoutsWarga')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/biodata.css') }}">
@endpush
@section('content')
    <div class="header">
        <h2>Biodata</h2>
        <p>{{ $biodata['nama'] ?? '-' }} ( {{ $biodata['status_dalam_keluarga'] ?? '-'}} )</p>
    </div>

    @if(count($biodata) > 0)
    <div class="biodata">
        <table>
            <tbody>
                <tr><th>NIK</th><td>:{{ $biodata['nik'] ?? '-' }}</td></tr>
                <tr><th>Nama</th><td>:{{ $biodata['nama'] ?? '-' }}</td></tr>
                <tr><th>Tempat/Tgl Lahir</th><td>:{{ $biodata['tempat_lahir'] ?? '-' }}, {{ $biodata['tanggal_lahir'] ?? '-' }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>:{{ $biodata['jenis_kelamin'] ?? '-' }}</td></tr>
                <tr><th>Alamat</th><td>:{{ $biodata['nama_jalan'] ?? '-' }}</td></tr>
                <tr><th>RT/RW</th><td>:{{ $biodata['rt'] ?? '-' }}/{{ $biodata['rw'] ?? '-' }}</td></tr>
            </tbody>
        </table>
        

        <table>
            <tbody>
                <tr><th>Kel/Desa</th><td>:{{ $biodata['kelurahan'] ?? '-' }}</td></tr>
                <tr><th>Kecamatan</th><td>:{{ $biodata['kecamatan'] ?? '-' }}</td></tr>
                <tr><th>Agama</th><td>:{{ $biodata['agama'] ?? '-' }}</td></tr>
                <tr><th>Status Perkawinan</th><td>:{{ $biodata['status_perkawinan'] ?? '-' }}</td></tr>
                <tr><th>Pekerjaan</th><td>:{{ $biodata['pekerjaan'] ?? '-' }}</td></tr>
                <tr><th>Kewarganegaraan</th><td>:{{ $biodata['kewarganegaraan'] ?? '-' }}</td></tr>
            </tbody>
        </table>
    </div>
    @else
        <p style="text-align:center; color:#2C6F56;">Tidak ada data ditemukan.</p>
    @endif

    <div class="header">
        <h2>Anggota Keluarga</h2>
        <p>{{ $biodata['nama'] ?? '-' }} Jr. ( Anak )</p>
    </div>

@endsection