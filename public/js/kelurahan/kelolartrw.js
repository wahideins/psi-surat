document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalRTRW');
    const closeModal = document.getElementById('closeModal');
    const form = document.getElementById('formRTRW');

    // Event delegation agar tombol dinamis tetap berfungsi
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-rtrw')) {
            const uid = e.target.dataset.uid;
            const nama = e.target.dataset.nama;

            document.getElementById('uid').value = uid;
            document.getElementById('nama').value = nama;

            modal.style.display = 'block'; // ✅ Lebih aman
        }
    });

    // Tutup modal
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none'; // ✅
    });

    // Tampilkan nomor RT jika checkbox dicentang
    document.getElementById('checkRT').addEventListener('change', e => {
        document.getElementById('nomorRT').style.display = e.target.checked ? 'block' : 'none';
    });

    // Tampilkan nomor RW jika checkbox dicentang
    document.getElementById('checkRW').addEventListener('change', e => {
        document.getElementById('nomorRW').style.display = e.target.checked ? 'block' : 'none';
    });

    // Auto isi periode akhir (5 tahun setelah periode mulai)
    document.getElementById('periodeMulai').addEventListener('change', function () {
        const start = new Date(this.value);
        if (!isNaN(start)) {
            start.setFullYear(start.getFullYear() + 5);
            document.getElementById('periodeAkhir').value = start.toISOString().split('T')[0];
        }
    });

    // Submit form
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const data = {
            uid: document.getElementById('uid').value,
            nama: document.getElementById('nama').value,
            is_rt: document.getElementById('checkRT').checked,
            is_rw: document.getElementById('checkRW').checked,
            nomor_rt: document.getElementById('nomorRT').value || null,
            nomor_rw: document.getElementById('nomorRW').value || null,
            periode_mulai: document.getElementById('periodeMulai').value,
            periode_akhir: document.getElementById('periodeAkhir').value
        };

        try {
            const res = await fetch('/kelurahan/simpan-rtrw', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            if (result.confirm) {
                if (confirm(result.message)) {
                    data.force = true;
                    const res2 = await fetch('/kelurahan/simpan-rtrw', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(data)
                    });
                    const result2 = await res2.json();
                    alert(result2.message || 'Data berhasil diperbarui.');
                    modal.style.display = 'none'; // ✅ tutup modal
                }
            } else if (result.success) {
                alert(result.message);
                modal.style.display = 'none'; // ✅ tutup modal
            } else {
                alert('Gagal menyimpan: ' + result.message);
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });
});
