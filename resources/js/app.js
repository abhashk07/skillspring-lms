import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('theme-toggle');

    if (!toggle) return;

    // Load saved theme
    if (localStorage.theme === 'dark') {
        document.documentElement.classList.add('dark');
    }

    toggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');

        localStorage.theme = document.documentElement.classList.contains('dark')
            ? 'dark'
            : 'light';
    });
});

