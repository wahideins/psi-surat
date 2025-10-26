{{-- Modal --}}
<div id="modalRTRW" class="modal">
    <div class="modal-content">
        <h2>Tetapkan RT/RW</h2>
        <form id="formRTRW">
            @csrf
            <input type="hidden" id="uid" name="uid">
            
            <div>
                <label>Nama</label>
                <input type="text" id="nama" name="nama" readonly>
            </div>

            <div>
                <label><input type="checkbox" id="checkRT"> RT</label>
                <input type="number" id="nomorRT" placeholder="Nomor RT" style="display:none;">
            </div>

            <div>
                <label><input type="checkbox" id="checkRW"> RW</label>
                <input type="number" id="nomorRW" placeholder="Nomor RW" style="display:none;">
            </div>

            <div>
                <label>Periode Mulai</label>
                <input type="date" id="periodeMulai" required>
            </div>

            <div>
                <label>Periode Akhir</label>
                <input type="date" id="periodeAkhir" required readonly>
            </div>

            <button type="submit">Simpan</button>
            <button type="button" id="closeModal">Batal</button>
        </form>
    </div>
</div>
