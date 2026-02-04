function initSidebar() {

    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('open-sidebar');
    const closeBtn = document.getElementById('close-sidebar');

    function toggleSidebar(state) {
        if (state) {
            sidebar.classList.add('sidebar-active');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        } else {
            sidebar.classList.remove('sidebar-active');
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    }

    openBtn?.addEventListener('click', () => toggleSidebar(true));
    closeBtn?.addEventListener('click', () => toggleSidebar(false));
    overlay?.addEventListener('click', () => toggleSidebar(false));

    // Accordion
    document.querySelectorAll('.mobile-collapse-trigger').forEach(trigger => {
        trigger.addEventListener('click', function () {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

    // Dropdown
    document.querySelectorAll('.dropdown-toggle').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (window.innerWidth >= 768) {
                e.preventDefault();
                e.stopPropagation();
                const menu = this.nextElementSibling;
                menu.classList.toggle('show-dropdown');
            }
        });
    });
}

// 1️⃣ Load pertama
document.addEventListener('DOMContentLoaded', initSidebar);

// 2️⃣ Setelah Livewire re-render / pindah halaman
document.addEventListener('livewire:navigated', initSidebar);

// (kalau Livewire v2, pakai ini)
// Livewire.hook('message.processed', initSidebar);

// Tutup dropdown jika klik di luar
window.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu').forEach(m => {
        m.classList.remove('show-dropdown');
    });
});