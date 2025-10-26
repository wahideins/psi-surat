<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga</title>
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <script src="{{ asset('js/warga/dashboardWarga.js') }}" defer></script>
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
                    <li><a href="{{ route('dashboardWarga') }}">Dashboard</a></li>
                    <li><a href="{{ route('ajukanSurat')}}">Ajukan Surat</a></li>
                    <li><a href="{{ route('warga.riwayatSurat')}}">Riwayat Surat</a></li>
                    <li><a href="{{ route('biodataWarga') }}">Biodata</a></li>

                    <!-- Dropdown -->
                    <li class="dropdown">
                        <button class="dropdown-toggle" onclick="toggleDropdown(event, 'akun')">Akun > </button>
                        <ul class="dropdown-menu" id="akun">
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
</body>
</html>
