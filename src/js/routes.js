import Dashboard from './Components/Dashboard.vue';
import Rejected from './Components/Rejected.vue';
import Waiting from './Components/Waiting.vue';
import Selected from './Components/Selected.vue';
import Slots from './Components/Slots.vue';

export const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/selected',
        name: 'selected',
        component: Selected
    },
    {
        path: '/rejected',
        name: 'rejected',
        component: Rejected
    },
    {
        path: '/waiting',
        name: 'waiting',
        component: Waiting
    },
    {
        path: '/slots',
        name: 'slots',
        component: Slots

    }
];
