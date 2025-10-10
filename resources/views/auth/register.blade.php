<!-- resources/views/auth/register.blade.php -->
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Registrasi - SIMARSU</title>
  <!-- link ke file CSS jika ingin -->
  <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">

    <!-- Font Alexandria -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">
    <!-- Font Alexandria -->
</head>
<body>
  <main class="container">
    <form id="multiForm" method="POST" action="" novalidate>
      @csrf

      <h1 class="title">Daftar Akun</h1>

      <div class="progress">
        <div class="progress-bar" id="progressBar" style="width:33%"></div>
      </div>

      <!-- STEP 1: Personal -->
      <section class="form-step active" data-step="1">
        <h2>Informasi Pribadi</h2>
        <div class="field">
          <label for="nik">NIK</label>
          <input id="nik" name="nik" type="text" required />
          <small class="error"></small>
        </div>

        <div class="field">
          <label for="fullname">Nama Lengkap</label>
          <input id="fullname" name="fullname" type="text" required />
          <small class="error"></small>
        </div>

        <div class="field">
          <label for="tempat-lahir">Tempat Lahir</label>
          <input id="tempat-lahir" name="tempat-lahir" type="text" required />
          <small class="error"></small>
        </div>

        <div class="field">
          <label for="jenis-kelamin">Jenis Kelamin</label>
          <div class="radio-group">
            <label><input type="radio" name="jenis-kelamin" value="L"> Laki-Laki</label>
            <label><input type="radio" name="jenis-kelamin" value="P"> Perempuan</label>
          </div>
          <small class="error"></small>
        </div>

        <div class="field">
          <label for="status-perkawinan">Status Perkawinan</label>
          <div class="radio-group">
            <label><input type="radio" name="status-perkawinan" value="belum-kawin"> Belum Kawin</label>
            <label><input type="radio" name="status-perkawinan" value="sudah-menikah"> Sudah Menikah</label>
          </div>
          <small class="error"></small>
        </div>


        <div class="field">
          <label for="pekerjaan">Pekerjaan</label>
          <input id="pekerjaan" name="pekerjaan" type="text" required />
          <small class="error"></small>
        </div>

        <div class="field">
          <label for="phone">No. Handphone</label>
          <input id="phone" name="phone" type="tel" required />
          <small class="error"></small>
        </div>

        <div class="actions">
          <button type="button" class="btn btn-next">Lanjutkan</button>
        </div>
      </section>

      <!-- STEP 2: Address -->
      <section class="form-step" data-step="2">
        <h2>Alamat</h2>
        <div class="field">
          <label for="address">Alamat Lengkap</label>
          <input id="address" name="address" type="text" required />
          <small class="error"></small>
        </div>

        <div class="field-grid">
          <div class="field">
            <label for="rt">RT</label>
            <input id="rt" name="rt" type="number" required />
            <small class="error"></small>
          </div>
          <div class="field">
            <label for="rw">RW</label>
            <input id="rw" name="rw" type="number"/>
            <small class="error"></small>
          </div>
        </div>

        <div class="field-grid">
          <div class="field">
            <label for="kel-desa">Kelurahan/Desa</label>
            <input id="kel-desa" name="kel-desa" type="text" required />
            <small class="error"></small>
          </div>

          <div class="field">
            <label for="kecamatan">Kecamatan</label>
            <input id="kecamatan" name="kecamatan" type="text" required />
            <small class="error"></small>
          </div>
        </div>


        <div class="field-grid">
          <div class="field">
            <label for="city">Kota/Kab</label>
            <input id="city" name="city" type="text" required />
            <small class="error"></small>
          </div>

          <div class="field">
            <label for="postal">Kode Pos</label>
            <input id="postal" name="postal" type="text" pattern="\d{4,6}" />
            <small class="error"></small>
          </div>
        </div>

        <div class="field">
          <label for="ktp">Upload KTP atau Kartu Identitas</label>
          <input id="ktp" name="ktp" type="file" accept="image/*,.pdf" />
          <small class="error"></small>
        </div>


        <div class="actions">
          <button type="button" class="btn btn-prev">Kembali</button>
          <button type="button" class="btn btn-next">Lanjutkan</button>
        </div>
      </section>

      <!-- STEP 3: Account -->
      <section class="form-step" data-step="3">
        <h2>Akun</h2>
        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required />
          <small class="error"></small>
        </div>

        <div class="field-grid">
          <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" minlength="8" required />
            <small class="error"></small>
          </div>
          <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required />
            <small class="error"></small>
          </div>
        </div>


        <div class="actions">
          <button type="button" class="btn btn-prev">Kembali</button>
          <button type="submit" class="btn btn-submit">Daftar</button>
        </div>
      </section>

      <!-- Optional confirm message area -->
      <div id="formMsg" class="form-msg" aria-live="polite"></div>
    </form>
  </main>

  <!-- link ke file JS jika ingin -->
  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
