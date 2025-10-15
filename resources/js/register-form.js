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
    const stateSelect = document.querySelector('#state');
    const municipalitySelect = document.querySelector('#municipality');
    const parishSelect = document.querySelector('#parish');
    const communeSelect = document.querySelector('#commune');

    async function loadStates() {
        try {
            const resp = await fetch('/address/states');
            const json = await resp.json();
            if (json.ok && stateSelect) {
                populateSelect(stateSelect, json.data, true);
                const oldState = stateSelect.dataset.old;
                if (oldState) stateSelect.value = oldState;
                if (stateSelect.value) await loadMunicipalities(stateSelect.value);
            }
        } catch (err) {
            console.error('states load error', err);
        }
    }

    async function loadMunicipalities(stateId) {
        municipalitySelect && (municipalitySelect.disabled = true);
        try {
            const resp = await fetch('/address/municipalities', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin',
                body: JSON.stringify({ state_id: stateId })
            });
            if (!resp.ok) throw new Error('HTTP ' + resp.status);
            const json = await resp.json();
            if (json.ok && municipalitySelect) {
                populateSelect(municipalitySelect, json.data, true);
                municipalitySelect.disabled = false;
                const oldMun = municipalitySelect.dataset.old;
                if (oldMun) {
                    municipalitySelect.value = oldMun;
                    await loadParishes(oldMun);
                }
            }
        } catch (err) {
            console.error('municipalities load error', err);
            const errBox = document.querySelector('#address-error');
            if (errBox) {
                errBox.style.display = 'block';
                errBox.textContent = 'No se pudieron cargar los municipios. Revisa la consola del navegador.';
            }
        }
    }

    async function loadParishes(municipalityId) {
        parishSelect && (parishSelect.disabled = true);
        try {
            const resp = await fetch('/address/parishes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin',
                body: JSON.stringify({ municipality_id: municipalityId })
            });
            if (!resp.ok) throw new Error('HTTP ' + resp.status);
            const json = await resp.json();
            if (json.ok && parishSelect) {
                populateSelect(parishSelect, json.data, true);
                parishSelect.disabled = false;
                const oldPar = parishSelect.dataset.old;
                if (oldPar) {
                    parishSelect.value = oldPar;
                    await loadCommunes(oldPar);
                }
            }
        } catch (err) {
            console.error('parishes load error', err);
            const errBox = document.querySelector('#address-error');
            if (errBox) {
                errBox.style.display = 'block';
                errBox.textContent = 'No se pudieron cargar las parroquias. Revisa la consola del navegador.';
            }
        }
    }

    async function loadCommunes(parishId) {
        communeSelect && (communeSelect.disabled = true);
        try {
            const resp = await fetch('/address/communes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin',
                body: JSON.stringify({ parish_id: parishId })
            });
            if (!resp.ok) throw new Error('HTTP ' + resp.status);
            const json = await resp.json();
            if (json.ok && communeSelect) {
                populateSelect(communeSelect, json.data, true);
                communeSelect.disabled = false;
                const oldCom = communeSelect.dataset.old;
                if (oldCom) communeSelect.value = oldCom;
            }
        } catch (err) {
            console.error('communes load error', err);
            const errBox = document.querySelector('#address-error');
            if (errBox) {
                errBox.style.display = 'block';
                errBox.textContent = 'No se pudieron cargar las comunas. Revisa la consola del navegador.';
            }
        }
    }

    function populateSelect(select, items) {
        if (!select) return;
        select.innerHTML = '<option value="">-- Seleccione --</option>';
        items.forEach(it => {
            const opt = document.createElement('option');
            opt.value = it.id;
            opt.textContent = it.name;
            select.appendChild(opt);
        });
    }

    // Load chained selects: estado -> municipio -> parroquia -> comuna

    async function lookupCedula() {
        if (!cedulaInput) return;
        const cedula = cedulaInput.value.trim();
        if (!cedula) return;
        lookupStatus.textContent = 'Buscando...';
        lookupBtn.disabled = true;
        try {
            const resp = await fetch('/lookup-id/' + cedula, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
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
        // toggle step descriptions
        const descs = document.querySelectorAll('.step-desc');
        descs.forEach(d => {
            d.style.display = d.dataset.stepDesc == index ? 'block' : 'none';
        });
        // show 'have-account' only on step 0 and 2
        const haveAccount = document.querySelector('#have-account');
        if (haveAccount) {
            haveAccount.style.display = (index === 0 || index === 2) ? 'flex' : 'none';
        }
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            // basic validation: required fields inside current step
            const inputs = steps[current].querySelectorAll('input[required], textarea[required], select[required]');
            for (let inp of inputs) {
                if (!inp.value.trim()) {
                    inp.classList.add('border-red-500');
                    inp.focus();
                    return;
                }
            }
            // special handling for first step
            if (current === 0) {
                const personal = document.querySelector('#personal-fields');
                // if personal block is hidden, reveal it first (no advance)
                if (personal && personal.style.display === 'none') {
                    personal.style.display = 'block';
                    return;
                }
                // if personal block is visible, require key personal fields before advancing
                if (personal && personal.style.display !== 'none') {
                        const requiredPersonal = ['#primer_nombre', '#primer_apellido'];
                        for (let sel of requiredPersonal) {
                            const el = document.querySelector(sel);
                            if (!el) continue;
                            const val = (el.value || '').toString().trim();
                            const isReadonly = el.hasAttribute('readonly');
                            // allow readonly fields if they have a value
                            if (val.length === 0) {
                                if (isReadonly) {
                                    // readonly but empty -> still invalid
                                    el.classList.add('border-red-500');
                                    el.focus();
                                    return;
                                } else {
                                    // editable and empty -> invalid
                                    el.classList.add('border-red-500');
                                    el.focus();
                                    return;
                                }
                            }
                        }
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

    // lookup ahora se hace mediante submit al controlador (no JS). No attach de evento aquí.

    if (stateSelect) loadStates();

    // wire change handlers
    stateSelect && stateSelect.addEventListener('change', (e) => {
        const val = e.target.value;
        if (val) loadMunicipalities(val);
        // reset downstream
        municipalitySelect && (municipalitySelect.innerHTML = '<option value="">Seleccione estado primero</option>', municipalitySelect.disabled = true);
        parishSelect && (parishSelect.innerHTML = '<option value="">Seleccione municipio primero</option>', parishSelect.disabled = true);
        communeSelect && (communeSelect.innerHTML = '<option value="">Seleccione parroquia primero</option>', communeSelect.disabled = true);
    });

    municipalitySelect && municipalitySelect.addEventListener('change', (e) => {
        const val = e.target.value;
        if (val) loadParishes(val);
        parishSelect && (parishSelect.innerHTML = '<option value="">Cargando parroquias...</option>', parishSelect.disabled = true);
        communeSelect && (communeSelect.innerHTML = '<option value="">Seleccione parroquia primero</option>', communeSelect.disabled = true);
    });

    parishSelect && parishSelect.addEventListener('change', (e) => {
        const val = e.target.value;
        if (val) loadCommunes(val);
        communeSelect && (communeSelect.innerHTML = '<option value="">Cargando comunas...</option>', communeSelect.disabled = true);
    });

    showStep(current);
});
