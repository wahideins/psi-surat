<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Surat Pengantar RT/RW</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            margin: 40px;
            line-height: 1.6;
        }
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .judul {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 18px;
        }
        .isi {
            text-align: justify;
            margin-top: 20px;
        }
        .ttd {
            display:flex;
            justify-content:center;
            margin-top: 40px;
            text-align: right;
        }
        .ttd-rt{
            text-align:left;
        }
    </style>
</head>
<body>

    <div class="kop">
        <h3>RUKUN TETANGGA DAN RUKUN WARGA</h3>
        <p>Desa {{ $biodata['kelurahan'] ?? '-' }}, Kecamatan {{ $biodata['kecamatan'] ?? '-' }}</p>
    </div>

    <div class="judul">SURAT PENGANTAR RT/RW</div>
    <p style="text-align:center;">Nomor: ................../{{$biodata['rt']}}/{{$biodata['rw']}}/{{ date('Y') }}</p>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

        <table style="margin-left:20px;">
            <tr><td>Nama</td><td></td><td>:{{ $biodata['nama'] ?? '-' }}</td></tr>
            <tr><td>NIK</td><td></td><td>:{{ $biodata['nik'] ?? '-' }}</td></tr>
            <tr><td>Alamat</td><td></td><td>:{{ $biodata['alamat'] ?? '-' }}</td></tr>
        </table>

        <p>Adalah benar warga yang bertempat tinggal di alamat tersebut di atas dan yang bersangkutan bermaksud untuk:</p>
        <p style="margin-left:20px;"><b>{{ $kategori ?? '-' }}</b></p>

        <p>Demikian surat pengantar ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <div class="ttd-rt">
            <p style="color:white;">{{ $biodata['kota'] ?? 'Kota' }}, {{ $tanggal ?? '-' }}</p>
            <p>Ketua RT {{$biodata['rt']}}</p><br><br>
            <p><b>$namaRT</b></p>
        </div>
        <div class="ttd-rw">
            <p>{{ $biodata['kota'] ?? 'Kota' }}, {{ $tanggal ?? '-' }}</p>
            <p>Ketua RW {{$biodata['rw']}}</p><br><br>
            <p><b>$namaRW</b></p>
        </div>
    </div>

    <div class="lampiran">
        Lampiran:
        <img src="" alt="{{$biodata['foto_ktp_url']}}">
    </div>

</body>
</html>
