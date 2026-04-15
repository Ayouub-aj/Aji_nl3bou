// Shared UI Logic for Aji L3bo

document.addEventListener('DOMContentLoaded', () => {
    // Hamburger Menu Toggling
    const sidebar = document.querySelector('.admin-sidebar');
    const menuToggle = document.querySelector('#menu-toggle');
    const menuClose = document.querySelector('#menu-close');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
            sidebar.classList.remove('-translate-x-full');
        });
    }

    if (menuClose && sidebar) {
        menuClose.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebar.classList.add('-translate-x-full');
        });
    }

    // Close sidebar on overlay click (if we add an overlay)
    document.addEventListener('click', (e) => {
        if (sidebar && sidebar.classList.contains('active') && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove('active');
            sidebar.classList.add('-translate-x-full');
        }
    });

    // Capacity Selection in booking_client.php
    const capacityButtons = document.querySelectorAll('.capacity-btn');
    const playersInput = document.querySelector('#players_count');
    if (capacityButtons && playersInput) {
        capacityButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                capacityButtons.forEach(b => {
                    b.classList.remove('bg-primary-container', 'text-on-primary-container', 'font-bold');
                    b.classList.add('bg-surface-container-highest', 'text-on-surface');
                });
                btn.classList.add('bg-primary-container', 'text-on-primary-container', 'font-bold');
                btn.classList.remove('bg-surface-container-highest', 'text-on-surface');
                playersInput.value = btn.dataset.value;
            });
        });
    }

    // Time Slot Selection in booking_client.php
    const timeButtons = document.querySelectorAll('.time-btn');
    const timeInput = document.querySelector('#time');
    if (timeButtons && timeInput) {
        timeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                timeButtons.forEach(b => {
                    b.classList.remove('ring-2', 'ring-primary');
                });
                btn.classList.add('ring-2', 'ring-primary');
                timeInput.value = btn.dataset.value;
            });
        });
    }
});
