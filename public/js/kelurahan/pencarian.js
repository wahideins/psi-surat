document.addEventListener('DOMContentLoaded', function() {
    const inputCari = document.getElementById('inputCari');
    const dataWarga = document.getElementById('dataWarga');
    const loader = document.getElementById('loader');
    const modal = document.getElementById('modalRTRW');
    const formRTRW = document.getElementById('formRTRW');

    // === PENCARIAN ===
    inputCari.addEventListener('keyup', function() {
        const query = this.value.trim();
        const url = inputCari.dataset.url;

        loader.style.display = 'inline-block';

        fetch(`${url}?nama=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                dataWarga.innerHTML = '';

                if (data.length === 0) {
                    dataWarga.innerHTML = `<tr><td colspan="6" style="text-align:center;">Tidak ada data warga</td></tr>`;
                    return;
                }

                data.forEach(user => {
                    const detailUrl = DETAIL_WARGA_ROUTE.replace(':uid', user.uid);

                    dataWarga.innerHTML += `
                        <tr>
                            <td>${user.nik ?? '-'}</td>
                            <td>${user.nama ?? '-'}</td>
                            <td>${user.email ?? '-'}</td>
                            <td>${user.rt ?? '-'}</td>
                            <td>${user.rw ?? '-'}</td>
                            <td>
                                <a href="${detailUrl}">Detail</a>
                                <button class="btn-rtrw" data-uid="${user.uid}" data-nama="${user.nama}">
                                    Jadikan Sebagai RT/RW
                                </button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(err => console.error(err))
            .finally(() => {
                loader.style.display = 'none';
            });
    });

    // === EVENT DELEGATION UNTUK TOMBOL DINAMIS ===
    dataWarga.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-rtrw')) {
            const uid = e.target.dataset.uid;
            const nama = e.target.dataset.nama;

            // isi modal
            formRTRW.querySelector('input[name="uid"]').value = uid;
            formRTRW.querySelector('input[name="nama"]').value = nama;

            // tampilkan modal
            modal.style.display = 'block';
        }
    });

    // === TOMBOL CLOSE MODAL ===
    document.querySelector('.close-modal').addEventListener('click', function() {
        modal.style.display = 'none';
    });
});
