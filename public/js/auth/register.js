let currentStep = 1;
showStep(currentStep);

function showStep(n) {
    document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
    document.getElementById('step-' + n).classList.add('active');

    document.getElementById('prevBtn').style.display = n === 1 ? 'none' : 'inline';
    document.getElementById('nextBtn').style.display = n === 4 ? 'none' : 'inline';
    document.getElementById('submitBtn').style.display = n === 4 ? 'inline' : 'none';
}

function nextPrev(n) {
    // 🔹 Jika ingin lanjut (n = 1), validasi dulu step sekarang
    if (n === 1 && !validateStep(currentStep)) {
        return false;
    }

    currentStep += n;
    if (currentStep < 1) currentStep = 1;
    if (currentStep > 4) currentStep = 4;
    showStep(currentStep);
}

function validateStep(stepNum) {
    const step = document.getElementById('step-' + stepNum);
    const inputs = step.querySelectorAll('input[required], select[required]');
    let valid = true;

    inputs.forEach(input => {
        const parentLabel = input.closest('label') || input;
        input.classList.remove('invalid');
        parentLabel.style.color = 'inherit';

        // untuk radio button
        if (input.type === 'radio') {
            const group = document.querySelectorAll(`input[name="${input.name}"]`);
            const checked = Array.from(group).some(r => r.checked);
            if (!checked) {
                valid = false;
                group.forEach(r => r.closest('label').style.color = 'red');
            }
        } else if (!input.value.trim()) {
            input.classList.add('invalid');
            valid = false;
        }
    });

    if (!valid) {
        alert('Mohon isi semua kolom wajib di langkah ini sebelum lanjut.');
    }

    return valid;
}

// === Data Wilayah ===
const kotaData = {
    "Kediri": ["Kota", "Mojoroto", "Pesantren"],
};

const kelurahanData = {
    "Kota": ["Semampir", 
        "Dandangan",
        "Ngadirejo",
        "Pakelan",
        "Pocanan",
        "Banjaran",
        "Jagalan",
        "Kemasan",
        "Kaliombo",
        "Kampung Dalem",
        "Ngronggo",
        "Manisrenggo",
        "Balowerti",
        "Rejomulyo",
        "Ringin Anom",
        "Setono Gedong",
        "Setono Pande"
    ],
    "Mojoroto": [
        "Lirboyo",
        "Campurejo",
        "Bandar Lor",
        "Dermo",
        "Mrican",
        "Mojoroto",
        "Ngampel",
        "Gayam",
        "Sukorame",
        "Pojok",
        "Tamanan",
        "Bandar Kidul",
        "Banjarmelati",
        "Bujel",
    ],
    "Peantren": [
        "Jamsaren", 
        "Bangsal",
        "Burengan",
        "Pesantren",
        "Pakunden",
        "Singonegaran",
        "Tinalan",
        "Banaran",
        "Tosaren",
        "Betet",
        "Blabak",
        "Bawang",
        "Ngletih",
        "Tempurejo",
        "Ketami",
    ],
};

// === Dropdown Dinamis ===
const kotaSelect = document.getElementById('kota');
const kecamatanSelect = document.getElementById('kecamatan');
const kelurahanSelect = document.getElementById('kelurahan');

Object.keys(kotaData).forEach(kota => {
    kotaSelect.innerHTML += `<option value="${kota}">${kota}</option>`;
});

kotaSelect.addEventListener('change', () => {
    const kecamatanList = kotaData[kotaSelect.value] || [];
    kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kel/Desa --</option>';
    kecamatanList.forEach(kec => {
        kecamatanSelect.innerHTML += `<option value="${kec}">${kec}</option>`;
    });
});

kecamatanSelect.addEventListener('change', () => {
    const kelList = kelurahanData[kecamatanSelect.value] || [];
    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kel/Desa --</option>';
    kelList.forEach(kel => {
        kelurahanSelect.innerHTML += `<option value="${kel}">${kel}</option>`;
    });
});
