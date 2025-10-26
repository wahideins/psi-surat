@extends('kelurahan.layoutsKelurahan')

@section('title')
Kelola RT/RW
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kelurahan/daftarWarga.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelurahan/modalrtrw.css') }}">
@endpush

@push('scripts')
    <script>
        const DETAIL_WARGA_ROUTE = "{{ route('detailWarga', ':uid') }}";
        const SIMPAN_RT_RW_ROUTE = "{{ route('simpanRTRW') }}";
    </script>
    <script src="{{ asset('js/kelurahan/kelolartrw.js') }}"></script>
    <script src="{{ asset('js/kelurahan/pencarian.js') }}"></script>
@endpush


@section('content')

    <div class="judul">
        <h1>Kelola RT/RW</h1>
    </div>

    <div class="pencarian">
        <input 
            type="text" 
            id="inputCari" 
            placeholder="Cari warga berdasarkan nama..." 
            data-url="{{ route('cariWarga') }}"
            class="input-cari"
        >

        <div id="loader" class="loader" style="display: none;"></div>
    </div>


<div class="tabel-warga">
    <table id="tabelWarga">
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
        <tbody id="dataWarga">
            @forelse($warga as $user)
                <tr>
                    <td>{{ $user['nik'] ?? '-' }}</td>
                    <td>{{ $user['nama'] ?? '-' }}</td>
                    <td>{{ $user['email'] ?? '-' }}</td>
                    <td>{{ $user['rt'] ?? '-' }}</td>
                    <td>{{ $user['rw'] ?? '-' }}</td>
                    <td class="aksi">
                        <a href="{{ route('detailWarga', $user['uid']) }}">Detail</a>

                        <button class="btn-rtrw" data-uid="{{ $user['uid'] }}" data-nama="{{ $user['nama'] }}">
                            Jadikan Sebagai RT/RW
                        </button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada data warga</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('kelurahan.partials.modalRTRW')

@endsection