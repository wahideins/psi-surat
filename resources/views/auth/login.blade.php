<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIMARSU</title>

    <!-- Font Alexandria -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">
    <!-- Font Alexandria -->

    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- Font Inter -->

    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body>
    <main>
        <div class="container-kiri">
            <div class="logo">
                <img src="{{asset('/img/logo.png')}}" alt="">
            </div>
            <div class="deskripsi">
                <h1>Selamat Datang Kembali</h1>
                <p>Silahkan Isi Form yang Tersedia Untuk Melanjutkan</p>
            </div>
        </div>

        <div class="container-kanan">
            <div class="header">
                <h1>Login</h1>
            </div>
            <div class="form">
                <form action="">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" placeholder="Masukkan NIK Anda">

                    <label for="email">Email/No. Hp</label>
                    <input type="text" id="email" placeholder="Masukkan Email/No. HP Anda">

                    <label for="password">Password</label>
                    <input type="text" id="password" placeholder="Masukkan Password Anda">

                    <button type="submit" class="btn-submit">Login</button>
                    <p>Belum Punya Akun? <a href="{{url('/register')}}">Daftar</a></p>
                </form>
            </div>
        </div>
    </main>
</body>
</html>