// resources/js/app.js
//
// Vanilla JS — no Alpine, no Vue, just clean event handling.
// Wire: modals, Kanban drag-and-drop, ⌘K search shortcut, composer tabs.

import './bootstrap'; // your existing Laravel bootstrap (axios + CSRF)

/* =========================================================
   1. Modals — open/close via [data-modal-open] / [data-modal-close]
   ========================================================= */
document.addEventListener('click', (e) => {
    const opener = e.target.closest('[data-modal-open]');
    if (opener) {
        const modal = document.getElementById(opener.dataset.modalOpen);
        if (modal) {
            modal.classList.remove('hidden');
            modal.querySelector('[data-modal] > div, .relative')?.focus?.();
        }
        return;
    }
    const closer = e.target.closest('[data-modal-close]');
    if (closer) {
        closer.closest('[data-modal]')?.classList.add('hidden');
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('[data-modal]:not(.hidden)').forEach(m => m.classList.add('hidden'));
    }
});

/* =========================================================
   2. Kanban drag-and-drop
   - HTML5 native DnD (no library required)
   - Posts new status to /leads/{id}/status via fetch
   ========================================================= */
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

document.querySelectorAll('[data-lead-id]').forEach(card => {
    card.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', card.dataset.leadId);
        e.dataTransfer.effectAllowed = 'move';
        card.classList.add('opacity-50');
    });
    card.addEventListener('dragend', () => card.classList.remove('opacity-50'));
});

document.querySelectorAll('[data-kanban-dropzone]').forEach(zone => {
    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        zone.classList.add('ring-2', 'ring-brand-400', 'ring-offset-2');
    });
    zone.addEventListener('dragleave', () => {
        zone.classList.remove('ring-2', 'ring-brand-400', 'ring-offset-2');
    });
    zone.addEventListener('drop', async (e) => {
        e.preventDefault();
        zone.classList.remove('ring-2', 'ring-brand-400', 'ring-offset-2');
        const leadId = e.dataTransfer.getData('text/plain');
        const newStatus = zone.dataset.status;
        const card = document.querySelector(`[data-lead-id="${leadId}"]`);
        if (!card || card.dataset.leadStatus === newStatus) return;

        // Optimistic UI: move the card immediately
        zone.appendChild(card);
        card.dataset.leadStatus = newStatus;

        // Persist to backend
        try {
            const response = await fetch(`/leads/${leadId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: newStatus }),
            });
            if (!response.ok) throw new Error('Status update failed');
        } catch (err) {
            console.error(err);
            alert('Could not update lead status. Please refresh.');
        }
    });
});

/* =========================================================
   3. ⌘K / Ctrl+K — focus global search
   ========================================================= */
document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('global-search')?.focus();
    }
});

/* =========================================================
   4. Activity composer tabs (lead detail page)
   ========================================================= */
document.querySelectorAll('[data-composer-tab]').forEach(tab => {
    tab.addEventListener('click', () => {
        const type = tab.dataset.composerTab;
        document.querySelectorAll('[data-composer-tab]').forEach(t => {
            t.classList.remove('border-ink-900', 'text-ink-900');
            t.classList.add('border-transparent', 'text-ink-500');
        });
        tab.classList.add('border-ink-900', 'text-ink-900');
        tab.classList.remove('border-transparent', 'text-ink-500');

        const hidden = document.getElementById('composer-type');
        if (hidden) hidden.value = type;
    });
});

/* =========================================================
   5. Activity timeline filter
   ========================================================= */
document.querySelectorAll('[data-activity-filter]').forEach(btn => {
    btn.addEventListener('click', () => {
        const filter = btn.dataset.activityFilter;
        document.querySelectorAll('[data-activity-filter]').forEach(b => {
            b.classList.remove('text-ink-700', 'bg-ink-100', 'font-medium');
            b.classList.add('text-ink-500');
        });
        btn.classList.add('text-ink-700', 'bg-ink-100', 'font-medium');
        btn.classList.remove('text-ink-500');

        document.querySelectorAll('[data-timeline-item]').forEach(item => {
            if (filter === 'all' || item.dataset.timelineItem === filter) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });
});
