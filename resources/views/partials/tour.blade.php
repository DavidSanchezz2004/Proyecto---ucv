{{-- Tour / Coach Marks Engine --}}
<div class="tour-overlay" id="tourOverlay"></div>

<div class="tour-popover arrow-top" id="tourPopover" role="dialog" aria-label="Guía de uso">
    <div class="tour-pov-header">
        <div class="tour-icon-box" id="tourIconBox">
            <i class="bi bi-info-circle"></i>
        </div>
        <button type="button" class="tour-close-btn" id="tourCloseBtn" aria-label="Cerrar guía">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="tour-title"  id="tourTitle"></div>
    <div class="tour-desc"   id="tourDesc"></div>
    <div class="tour-tip"    id="tourTip" style="display:none"></div>
    <div class="tour-footer">
        <div class="tour-dots" id="tourDots"></div>
        <div class="tour-actions">
            <button type="button" class="tour-btn tour-btn-ghost" id="tourPrev" disabled>
                <i class="bi bi-arrow-left"></i>
            </button>
            <button type="button" class="tour-btn tour-btn-ghost" id="tourSkip">Omitir</button>
            <button type="button" class="tour-btn tour-btn-primary" id="tourNext">
                Siguiente <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
const SOLTour = (function () {
    const _uid = {{ auth()->id() ?? 0 }};

    let _steps = [], _cur = 0, _on = false, _key = '', _hl = null;

    const overlay  = document.getElementById('tourOverlay');
    const popover  = document.getElementById('tourPopover');
    const iconBox  = document.getElementById('tourIconBox');
    const titleEl  = document.getElementById('tourTitle');
    const descEl   = document.getElementById('tourDesc');
    const tipEl    = document.getElementById('tourTip');
    const dotsEl   = document.getElementById('tourDots');
    const btnPrev  = document.getElementById('tourPrev');
    const btnSkip  = document.getElementById('tourSkip');
    const btnNext  = document.getElementById('tourNext');
    const closeBtn = document.getElementById('tourCloseBtn');

    const sKey   = () => `sol_tour_${_key}_${_uid}`;
    const isDone = () => localStorage.getItem(sKey()) === '1';
    const done   = () => localStorage.setItem(sKey(), '1');

    function clearHL() {
        if (_hl) { _hl.classList.remove('tour-highlighted'); _hl = null; }
    }

    function dots() {
        dotsEl.innerHTML = '';
        _steps.forEach((_, i) => {
            const d = document.createElement('span');
            d.className = 'tour-dot' + (i === _cur ? ' active' : '');
            dotsEl.appendChild(d);
        });
    }

    function arrow(a) {
        popover.classList.remove('arrow-left','arrow-right','arrow-top','arrow-bottom');
        if (a) popover.classList.add('arrow-' + a);
    }

    function place(el, a) {
        const r  = el.getBoundingClientRect();
        const pw = popover.offsetWidth  || 370;
        const ph = popover.offsetHeight || 250;
        const g  = 14, m = 10;
        let l, t;
        if      (a === 'right')  { l = r.left - pw - g;      t = r.top + r.height/2 - ph/2; }
        else if (a === 'bottom') { l = r.left;                t = r.top  - ph - g;           }
        else if (a === 'top')    { l = r.left;                t = r.bottom + g;              }
        else                     { l = r.right + g;           t = r.top + r.height/2 - ph/2; }
        popover.style.left = Math.max(m, Math.min(l, window.innerWidth  - pw - m)) + 'px';
        popover.style.top  = Math.max(m, Math.min(t, window.innerHeight - ph - m)) + 'px';
    }

    function go(idx) {
        _cur = idx;
        const s  = _steps[_cur];
        if (!s) return;
        const el = document.querySelector(s.target);
        if (!el) { _cur < _steps.length - 1 ? go(_cur + 1) : close(); return; }

        clearHL();
        _hl = el;

        iconBox.innerHTML   = `<i class="bi bi-${s.icon || 'info-circle'}"></i>`;
        titleEl.textContent = s.title;
        descEl.textContent  = s.desc;

        if (s.tip) {
            tipEl.innerHTML     = `<i class="bi bi-lightbulb me-1"></i><strong>Consejo:</strong> ${s.tip}`;
            tipEl.style.display = '';
        } else {
            tipEl.style.display = 'none';
        }

        const last          = _cur === _steps.length - 1;
        btnPrev.disabled    = _cur === 0;
        btnNext.innerHTML   = last ? '<i class="bi bi-check2 me-1"></i>¡Listo!' : 'Siguiente <i class="bi bi-arrow-right ms-1"></i>';
        btnNext.className   = 'tour-btn ' + (last ? 'tour-btn-success' : 'tour-btn-primary');

        arrow(s.arrow || 'top');
        dots();

        el.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
        setTimeout(() => { el.classList.add('tour-highlighted'); place(el, s.arrow || 'top'); }, 300);
    }

    function open()  { _on = true;  overlay.classList.add('tour-show'); popover.classList.add('tour-show'); go(0); }
    function close() { _on = false; overlay.classList.remove('tour-show'); popover.classList.remove('tour-show'); clearHL(); done(); }

    closeBtn.addEventListener('click', close);
    btnSkip.addEventListener('click',  close);
    overlay.addEventListener('click',  close);
    btnNext.addEventListener('click',  () => _cur >= _steps.length - 1 ? close() : go(_cur + 1));
    btnPrev.addEventListener('click',  () => _cur > 0 && go(_cur - 1));

    window.addEventListener('resize',  () => { if (!_on) return; const s = _steps[_cur]; const el = s && document.querySelector(s.target); if (el) place(el, s.arrow || 'top'); });
    document.addEventListener('keydown', e => { if (!_on) return; if (e.key==='Escape') close(); if (e.key==='ArrowRight') _cur<_steps.length-1?go(_cur+1):close(); if (e.key==='ArrowLeft'&&_cur>0) go(_cur-1); });

    return {
        init(cfg) {
            _steps = cfg.steps   || [];
            _key   = cfg.pageKey || 'page';
            document.querySelectorAll('[data-tour-start]').forEach(btn => {
                btn.addEventListener('click', () => { localStorage.removeItem(sKey()); open(); });
            });
            if (cfg.autoStart !== false && !isDone()) setTimeout(open, 900);
        }
    };
})();
</script>
