import './bootstrap';

import Alpine from 'alpinejs';
import * as Turbo from '@hotwired/turbo';

window.Alpine = Alpine;

document.addEventListener('turbo:before-cache', () => {
    Alpine.destroy();
});

document.addEventListener('turbo:load', () => {
    Alpine.start();
});

Alpine.start();
