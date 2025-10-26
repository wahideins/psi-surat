document.addEventListener('DOMContentLoaded', () => {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation(); // hindari trigger global click
            const parent = toggle.closest('.dropdown');

            // Tutup dropdown lain yang terbuka
            document.querySelectorAll('.dropdown').forEach(drop => {
                if (drop !== parent) drop.classList.remove('active');
            });

            // Toggle dropdown saat ini
            parent.classList.toggle('active');
        });
    });

    // Tutup dropdown jika klik di luar area
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown').forEach(drop => {
            drop.classList.remove('active');
        });
    });
});
