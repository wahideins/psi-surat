<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    @stack('styles')
</head>

<body>
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
    <div class="container">
        <div class="item" id="sidebar">
            <div class="logo">
                <img src="{{ asset('img/logo sukorame berdaya 2025.png') }}" alt="" width="164">
            </div>

            <div class="header">
                <h1>SIMARSU</h1>
            </div>

            <div class="nav-item">
                <ul>
                    <li><a href="{{ route('dashboardKelurahan') }}">Dashboard</a></li>
    
                    <!-- Dropdown Surat -->
                    <li class="dropdown">
                        <button class="dropdown-toggle" onclick="toggleDropdown(event, 'surat')">Surat</button>
                        <ul class="dropdown-menu" id="surat" style="display:none;">
                            <li><a href="">Nomor Surat</a></li>
                            <li><a href="">Surat Masuk</a></li>
                            <li><a href="">Riwayat Surat</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Kependudukan -->
                    <li class="dropdown">
                        <button class="dropdown-toggle" onclick="toggleDropdown(event, 'kependudukan')">Kependudukan </button>
                        <ul class="dropdown-menu" id="kependudukan" style="display:none;">
                            <li><a href="{{ route('daftarWarga') }}">Warga</a></li>
                            <li><a href="{{ route('jabatanWarga', ['field' => 'statusDiKeluarga', 'value' => 'Kepala Keluarga']) }}">Kepala Keluarga</a></li>
                            <li><a href="{{ route('halamanRT') }}">RT Aktif</a></li>
                            <li><a href="{{ route('halamanRW') }}">RW</a></li>

                            <li><a href="{{ route('kelolaRTRW') }}">Kelola RT/RW</a></li>
                            <li><a href="">Riwayat RT/RW</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Akun -->
                    <li class="dropdown">
                        <button class="dropdown-toggle" onclick="toggleDropdown(event, 'akun')">Akun > </button>
                        <ul class="dropdown-menu" id="akun" style="display:none;">
                            <li><a href="#">Kelola Akun</a></li>
                            <li><a href="{{ route('logout') }}" style="color:red;">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="item">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.item:nth-child(1)');
            sidebar.classList.toggle('active');
        }

        function toggleDropdown(event, id) {
            event.stopPropagation(); // mencegah event bubble ke document

            // Tutup semua dropdown lain
            const allDropdowns = document.querySelectorAll('.dropdown-menu');
            allDropdowns.forEach(menu => {
                if (menu.id !== id) {
                    menu.style.display = 'none';
                }
            });

            // Toggle dropdown yang diklik
            const current = document.getElementById(id);
            const isVisible = current.style.display === 'block';
            current.style.display = isVisible ? 'none' : 'block';
        }

        // Tutup dropdown saat klik di luar area
        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        });

    </script>

    @stack('scripts')
</body>
</html>
