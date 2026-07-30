import 'bootstrap';

import {
    createIcons,
    Mail,
    MapPin,
    Phone,
} from 'lucide';

const navbar = document.querySelector('[data-site-navbar]');

const updateNavbarState = () => {
    navbar?.classList.toggle('is-scrolled', window.scrollY > 16);
};

updateNavbarState();

window.addEventListener('scroll', updateNavbarState, {
    passive: true,
});

createIcons({
    icons: {
        Mail,
        MapPin,
        Phone,
    },
});