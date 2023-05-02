import Vue from './elements';
import Router from 'vue-router';
Vue.use(Router);

import { applyFilters, addFilter, addAction, doAction } from '@wordpress/hooks';

export default class eventSpeechOrganizer {
    constructor() {
        this.applyFilters = applyFilters;
        this.addFilter = addFilter;
        this.addAction = addAction;
        this.doAction = doAction;
        this.Vue = Vue;
        this.Router = Router;
    }

    $publicAssets(path){
        return (window.eventSpeechOrganizerAdmin.assets_url + path);
    }

    $get(options) {
        return window.jQuery.get(window.eventSpeechOrganizerAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        options.action = 'event_speech_organizer_admin_ajax';
        return window.jQuery.get(window.eventSpeechOrganizerAdmin.ajaxurl, options);
    }

    $post(options) {
        return window.jQuery.post(window.eventSpeechOrganizerAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = 'event_speech_organizer_admin_ajax';
        return window.jQuery.post(window.eventSpeechOrganizerAdmin.ajaxurl, options);
    }

    $getJSON(options) {
        return window.jQuery.getJSON(window.eventSpeechOrganizerAdmin.ajaxurl, options);
    }
}
