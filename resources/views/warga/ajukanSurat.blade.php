@extends('warga.layouts.layoutsWarga')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/ajukanSurat.css') }}">
@endpush
@section('content')
    <div class="header">
        <h2>Ajukan Surat Pengantar</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="header">
        <h3>Menerangkan Bahwa:</h3>
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

    <form id="formSurat" method="POST" action="{{ route('warga.ajukanSurat.submit') }}">
        @csrf
        <div class="form-group">
            <label for="kategori">Maksud/Tujuan</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="">-- Pilih Maksud/Tujuan --</option>
                <option value="Surat Keterangan Miskin">Surat Keterangan Miskin</option>
                <option value="Rekomendasi Perkawinan">Rekomendasi Perkawinan</option>
                <option value="Legalisasi Pendaftaran TNI PORLI">Legalisasi Pendaftaran TNI PORLI</option>
                <option value="Legalisasi Pernyataan Waris">Legalisasi Pernyataan Waris</option>
                <option value="Legalisasi Persyaratan Pensiun">Legalisasi Persyaratan Pensiun</option>
                <option value="Legalisasi Pengajuan Cerai PNS">Legalisasi Pengajuan Cerai PNS</option>
                <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                <option value="Rekomendasi Izin Keramaian">Rekomendasi Izin Keramaian</option>
                <option value="Surat Keterangan Bepergian (BORO)">Surat Keterangan Bepergian (BORO)</option>
                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                <option value="Surat Keterangan Kematian dan Kutipan Kematian">Surat Keterangan Kematian dan Kutipan Kematian</option>
                <option value="Surat Keterangan Penghasilan">Surat Keterangan Penghasilan</option>
                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                <option value="Legalisasi Surat Kuasa">Legalisasi Surat Kuasa</option>
                <option value="Keterangan Umum">Keterangan Umum</option>
                <option value="Lain-Lain">Lain-Lain</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keperluan">Keterangan</label>
            <textarea name="keperluan" id="keperluan" class="form-control" placeholder="(Opsional) Jelaskan Maksud/Tujuan Anda Mengirim Surat Ini"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
        <button type="button" id="previewBtn" class="btn btn-secondary">Preview</button>

        @if(session('preview_surat'))
            <a href="{{ route('cetakSurat') }}" class="btn btn-primary">Cetak PDF</a>
        @endif
    </form>

<script>
document.getElementById('previewBtn').addEventListener('click', function() {
    const form = document.getElementById('formSurat');
    const originalAction = form.action;
    const originalTarget = form.target;

    form.action = "{{ route('warga.ajukanSurat.preview') }}";
    form.target = "_blank"; // buka tab baru untuk preview
    form.submit();

    form.action = originalAction;
    form.target = originalTarget;
});
</script>
@endsection
