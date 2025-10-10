// public/js/register-multi.js
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('multiForm');
  const steps = Array.from(document.querySelectorAll('.form-step'));
  const nextBtns = Array.from(document.querySelectorAll('.btn-next'));
  const prevBtns = Array.from(document.querySelectorAll('.btn-prev'));
  const progressBar = document.getElementById('progressBar');
  const formMsg = document.getElementById('formMsg');

  let current = 0; // index of current step (0-based)

  function showStep(index) {
    steps.forEach((s, i) => s.classList.toggle('active', i === index));
    const pct = Math.round(((index + 1) / steps.length) * 100);
    progressBar.style.width = pct + '%';
    formMsg.textContent = '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function validateStep(index) {
    // Simple validation: required fields and pattern/minlength
    const step = steps[index];
    let valid = true;
    const inputs = Array.from(step.querySelectorAll('input'));

    inputs.forEach(input => {
      const errorEl = input.closest('.field')?.querySelector('.error');
      if (!errorEl) return; // skip kalau tidak ada elemen error
      errorEl.textContent = '';

      if (input.hasAttribute('required') && !input.value.trim()) {
        errorEl.textContent = 'Field wajib diisi';
        valid = false;
        return;
      }

      if (input.type === 'email' && input.value) {
        // simple email check
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!re.test(input.value)) {
          errorEl.textContent = 'Format email tidak valid';
          valid = false;
        }
      }

      if (input.hasAttribute('minlength')) {
        const min = parseInt(input.getAttribute('minlength'), 10);
        if (input.value.length < min) {
          errorEl.textContent = `Minimal ${min} karakter`;
          valid = false;
        }
      }

      if (input.hasAttribute('pattern') && input.value) {
        const pattern = new RegExp(input.getAttribute('pattern'));
        if (!pattern.test(input.value)) {
          errorEl.textContent = 'Format tidak valid';
          valid = false;
        }
      }

      // special check: password confirm if on last step
      if (input.id === 'password_confirmation') {
        const pw = document.getElementById('password').value;
        if (input.value !== pw) {
          errorEl.textContent = 'Password tidak cocok';
          valid = false;
        }
      }
    });

    return valid;
  }

  nextBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (validateStep(current)) {
        current = Math.min(current + 1, steps.length - 1);
        showStep(current);
      } else {
        formMsg.textContent = 'Periksa kembali input yang bertanda merah.';
        formMsg.style.color = 'var(--danger)';
      }
    });
  });

  prevBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      current = Math.max(current - 1, 0);
      showStep(current);
    });
  });

  // Final form submit: validate all steps
  form.addEventListener('submit', function (ev) {
    ev.preventDefault();

    // validate every step to ensure no missing values (client side)
    let allValid = true;
    for (let i = 0; i < steps.length; i++) {
      if (!validateStep(i)) {
        allValid = false;
        // go to first invalid step
        current = i;
        showStep(current);
        break;
      }
    }

    if (!allValid) {
      formMsg.textContent = 'Perbaiki input yang belum valid sebelum mengirim.';
      formMsg.style.color = 'var(--danger)';
      return;
    }

    // optional: show a "submitting" message
    formMsg.textContent = 'Mengirim data...';
    formMsg.style.color = 'var(--muted)';

    // Submit form normally (let Laravel handle CSRF and backend validation)
    // If you prefer AJAX, replace the next line with fetch/XHR.
    form.submit();
  });

  // initialize
  showStep(current);
});
