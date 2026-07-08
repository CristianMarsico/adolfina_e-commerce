import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import * as Turbo from '@hotwired/turbo';

window.Alpine = Alpine;

Alpine.plugin(collapse);

document.addEventListener('turbo:before-cache', () => {
    Alpine.destroy();
});

document.addEventListener('turbo:load', () => {
    Alpine.start();
});

Alpine.start();
