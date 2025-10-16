<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body style="font-family: Arial; text-align:center; margin-top: 100px;">
    <h2>Selamat datang, {{ session('user.email') }}</h2>
    <p>Anda berhasil login menggunakan Firebase Auth</p>
    <a href="{{ route('logout') }}">Logout</a>
</body>
</html>
