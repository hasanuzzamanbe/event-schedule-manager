import Vue from './elements';
import Router from 'vue-router';
Vue.use(Router);

import { applyFilters, addFilter, addAction, doAction } from '@wordpress/hooks';

export default class speakers {
    constructor() {
        this.applyFilters = applyFilters;
        this.addFilter = addFilter;
        this.addAction = addAction;
        this.doAction = doAction;
        this.Vue = Vue;
        this.Router = Router;
    }

    $publicAssets(path){
        return (window.speakersAdmin.assets_url + path);
    }

    $get(options) {
        return window.jQuery.get(window.speakersAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        options.action = 'speakers_admin_ajax';
        return window.jQuery.get(window.speakersAdmin.ajaxurl, options);
    }

    $post(options) {
        return window.jQuery.post(window.speakersAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = 'speakers_admin_ajax';
        return window.jQuery.post(window.speakersAdmin.ajaxurl, options);
    }

    $getJSON(options) {
        return window.jQuery.getJSON(window.speakersAdmin.ajaxurl, options);
    }
}
