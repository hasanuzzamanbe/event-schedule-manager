window.speakersBus = new window.speakers.Vue();

window.speakers.Vue.mixin({
    methods: {
        applyFilters: window.speakers.applyFilters,
        addFilter: window.speakers.addFilter,
        addAction: window.speakers.addFilter,
        doAction: window.speakers.doAction,
        $get: window.speakers.$get,
        $adminGet: window.speakers.$adminGet,
        $adminPost: window.speakers.$adminPost,
        $post: window.speakers.$post,
        $publicAssets: window.speakers.$publicAssets
    }
});

import {routes} from './routes';

const router = new window.speakers.Router({
    routes: window.speakers.applyFilters('speakers_global_vue_routes', routes),
    linkActiveClass: 'active'
});

import App from './AdminApp';

new window.speakers.Vue({
    el: '#speakers_app',
    render: h => h(App),
    router: router
});

