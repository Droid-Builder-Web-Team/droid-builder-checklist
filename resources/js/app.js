import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Check if the user prefers dark mode
const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

// Get the root HTML element
const root = document.documentElement;

// Function to enable or disable dark mode
function enableDarkMode() {
    root.classList.add('dark');
}

function disableDarkMode() {
    root.classList.remove('dark');
}

// Set the initial dark mode state based on user preference
if (prefersDarkMode) {
    enableDarkMode();
} else {
    disableDarkMode();
}

// Listen for changes in user preference
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (e.matches) {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
});
