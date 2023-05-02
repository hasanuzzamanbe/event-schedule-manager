window.eventSpeechOrganizerBus = new window.eventSpeechOrganizer.Vue();

window.eventSpeechOrganizer.Vue.mixin({
    methods: {
        applyFilters: window.eventSpeechOrganizer.applyFilters,
        addFilter: window.eventSpeechOrganizer.addFilter,
        addAction: window.eventSpeechOrganizer.addFilter,
        doAction: window.eventSpeechOrganizer.doAction,
        $get: window.eventSpeechOrganizer.$get,
        $adminGet: window.eventSpeechOrganizer.$adminGet,
        $adminPost: window.eventSpeechOrganizer.$adminPost,
        $post: window.eventSpeechOrganizer.$post,
        $publicAssets: window.eventSpeechOrganizer.$publicAssets
    }
});

import {routes} from './routes';

const router = new window.eventSpeechOrganizer.Router({
    routes: window.eventSpeechOrganizer.applyFilters('eventSpeechOrganizer_global_vue_routes', routes),
    linkActiveClass: 'active'
});

import App from './AdminApp';

new window.eventSpeechOrganizer.Vue({
    el: '#event_speech_organizer_app',
    render: h => h(App),
    router: router
});

