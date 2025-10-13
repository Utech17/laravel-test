// Simple multi-step form implementation without Vue
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#multi-step-form');
    if (!form) return;

    const steps = Array.from(form.querySelectorAll('[data-step]'));
    const nextBtns = form.querySelectorAll('[data-next]');
    const prevBtns = form.querySelectorAll('[data-prev]');
    const stepsNav = form.querySelectorAll('[data-step-nav]');
    let current = 0;
    const cedulaInput = document.querySelector('#cedula');
    const lookupBtn = document.querySelector('#cedula-lookup-btn');
    const lookupStatus = document.querySelector('#cedula-lookup-status');

    async function lookupCedula() {
        if (!cedulaInput) return;
        const cedula = cedulaInput.value.trim();
        if (!cedula) return;
        lookupStatus.textContent = 'Buscando...';
        lookupBtn.disabled = true;
        try {
            const resp = await fetch('/lookup-id', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ cedula })
            });
            const data = await resp.json();
            if (resp.ok && data.ok) {
                const d = data.data;
                // fill fields if present
                document.querySelector('#nacionalidad') && (document.querySelector('#nacionalidad').value = d.nacionalidad || '');
                document.querySelector('#cedula') && (document.querySelector('#cedula').value = d.cedula || '');
                document.querySelector('#primer_nombre') && (document.querySelector('#primer_nombre').value = d.primer_nombre || '');
                document.querySelector('#segundo_nombre') && (document.querySelector('#segundo_nombre').value = d.segundo_nombre || '');
                document.querySelector('#primer_apellido') && (document.querySelector('#primer_apellido').value = d.primer_apellido || '');
                document.querySelector('#segundo_apellido') && (document.querySelector('#segundo_apellido').value = d.segundo_apellido || '');
                document.querySelector('#fecha_nacimiento') && (document.querySelector('#fecha_nacimiento').value = d.fecha_nacimiento || '');
                document.querySelector('#sexo') && (document.querySelector('#sexo').value = d.sexo || '');
                lookupStatus.textContent = 'Datos cargados.';
                // show personal fields
                const personal = document.querySelector('#personal-fields');
                if (personal) personal.style.display = 'block';
            } else {
                lookupStatus.textContent = data.message || 'No se encontraron datos';
            }
        } catch (err) {
            console.error(err);
            lookupStatus.textContent = 'Error en la búsqueda';
        } finally {
            lookupBtn.disabled = false;
        }
    }

    function showStep(index) {
        steps.forEach((s, i) => {
            s.style.display = i === index ? 'block' : 'none';
        });
        stepsNav.forEach((n, i) => {
            n.classList.toggle('font-bold', i === index);
            n.classList.toggle('text-blue-600', i === index);
        });
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            // basic validation: required fields inside current step
            const inputs = steps[current].querySelectorAll('input, textarea');
            for (let inp of inputs) {
                if (inp.hasAttribute('required') && !inp.value.trim()) {
                    inp.classList.add('border-red-500');
                    inp.focus();
                    return;
                }
            }
            // if on first step and personal fields are hidden, show them instead of moving on
            if (current === 0) {
                const personal = document.querySelector('#personal-fields');
                if (personal && personal.style.display === 'none') {
                    personal.style.display = 'block';
                    return;
                }
            }
            if (current < steps.length - 1) {
                current++;
                showStep(current);
            } else {
                form.submit();
            }
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (current > 0) {
                current--;
                showStep(current);
            }
        });
    });

    // Clicking on step nav jumps to that step
    stepsNav.forEach((nav, idx) => {
        nav.addEventListener('click', (e) => {
            e.preventDefault();
            current = idx;
            showStep(current);
        });
    });

    if (lookupBtn) {
        lookupBtn.addEventListener('click', (e) => {
            e.preventDefault();
            lookupCedula();
        });
    }

    showStep(current);
});
