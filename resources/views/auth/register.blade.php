<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi SIMARSU</title>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    <style>
        .alert-danger {
            background-color: #ffe4e4;
            border: 1px solid #ff4d4d;
            color: #a60000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .alert-success {
            background-color: #e8ffea;
            border: 1px solid #32cd32;
            color: #2d7a2d;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .error {
            color: #d00;
            font-size: 0.9em;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>
<body>

<h2>Registrasi SIMARSU</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('form.user.submit') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Bagian 1: Biodata -->
    <div class="step active" id="step-1">
        <h3>Bagian 1: Biodata</h3>

        <label>NIK:</label>
        <input type="text" name="nik" value="{{ old('nik') }}" required>
        @error('nik') <span class="error">{{ $message }}</span> @enderror

        <label>Nama:</label>
        <input type="text" name="nama" value="{{ old('nama') }}" required>
        @error('nama') <span class="error">{{ $message }}</span> @enderror

        <label>Tempat Lahir:</label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
        @error('tempat_lahir') <span class="error">{{ $message }}</span> @enderror

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
        @error('tanggal_lahir') <span class="error">{{ $message }}</span> @enderror

        <label>Jenis Kelamin:</label>
        <div class="radio-group">
            <label><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
            <label><input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
        </div>
        @error('jenis_kelamin') <span class="error">{{ $message }}</span> @enderror

        <label>Agama:</label>
        <input type="text" name="agama" value="{{ old('agama') }}" required>
        @error('agama') <span class="error">{{ $message }}</span> @enderror

        <label>No. HP:</label>
        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="8123456789" required>
        @error('no_hp') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Bagian 2: Status -->
    <div class="step" id="step-2">
        <h3>Bagian 2: Status</h3>

        <label>Status Perkawinan:</label>
        <div class="radio-group">
            <label><input type="radio" name="status_perkawinan" value="Belum" {{ old('status_perkawinan') == 'Belum' ? 'checked' : '' }}> Belum</label>
            <label><input type="radio" name="status_perkawinan" value="Sudah" {{ old('status_perkawinan') == 'Sudah' ? 'checked' : '' }}> Sudah</label>
        </div>
        @error('status_perkawinan') <span class="error">{{ $message }}</span> @enderror

        <label>Status Dalam Keluarga:</label>
        <select name="status_dalam_keluarga" required>
            <option value="">-- Pilih --</option>
            <option value="Kepala Keluarga" {{ old('status_dalam_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
            <option value="Anak" {{ old('status_dalam_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
            <option value="Istri" {{ old('status_dalam_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
            <option value="Famili Lain" {{ old('status_dalam_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
        </select>
        @error('status_dalam_keluarga') <span class="error">{{ $message }}</span> @enderror

        <label>Pekerjaan:</label>
        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
        @error('pekerjaan') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Bagian 3: Alamat -->
    <div class="step" id="step-3">
        <h3>Bagian 3: Alamat</h3>

        <label>Nama Jalan:</label>
        <input type="text" name="nama_jalan" value="{{ old('nama_jalan') }}" required>
        @error('nama_jalan') <span class="error">{{ $message }}</span> @enderror

        <label>Provinsi:</label>
        <input type="text" name="provinsi" value="Jawa Timur" readonly>

        <label>Kota/Kab:</label>
        <select name="kota" id="kota" required>
            <option value="">-- Pilih Kota --</option>
        </select>
        @error('kota') <span class="error">{{ $message }}</span> @enderror

        <label>Kecamatan:</label>
        <select name="kecamatan" id="kecamatan" required></select>
        @error('kecamatan') <span class="error">{{ $message }}</span> @enderror

        <label>Kel/Desa:</label>
        <select name="kelurahan" id="kelurahan" required></select>
        @error('kelurahan') <span class="error">{{ $message }}</span> @enderror

        <label>RT:</label>
        <input type="number" name="rt" value="{{ old('rt') }}" max="37" required>
        @error('rt') <span class="error">{{ $message }}</span> @enderror

        <label>RW:</label>
        <input type="number" name="rw" value="{{ old('rw') }}" max="10" required>
        @error('rw') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Bagian 4: Akun -->
    <div class="step" id="step-4">
        <h3>Bagian 4: Akun</h3>

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <span class="error">{{ $message }}</span> @enderror

        <label>Password:</label>
        <input type="password" name="password" required>
        @error('password') <span class="error">{{ $message }}</span> @enderror

        <label>Foto KTP:</label>
        <input type="file" name="foto_ktp" accept="image/*" required>
        @error('foto_ktp') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="nav-buttons">
        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Sebelumnya</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Berikutnya</button>
        <button type="submit" id="submitBtn">Simpan</button>
    </div>
</form>

<script src="{{ asset('js/auth/register.js') }}"></script>
</body>
</html>
