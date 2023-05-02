<?php

namespace EventSpeechOrganizer\Classes;

use EventSpeechOrganizer\Classes\ApplicantModel;

class Menu
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenus'));
    }

    public function addMenus()
    {
        $menuPermission = AccessControl::hasTopLevelMenuPermission();
        if (!$menuPermission) {
            return;
        }

        $title = __('Events', 'textdomain');
        global $submenu;
        add_menu_page(
            $title,
            $title,
            $menuPermission,
            'event_speech_organizer.php',
            array($this, 'enqueueAssets'),
            'dashicons-admin-site',
            25
        );

        $submenu['event_speech_organizer.php']['applicants'] = array(
            __('My events', 'textdomain'),
            $menuPermission,
            'admin.php?page=event_speech_organizer.php#/',
        );
        // $submenu['event_speech_organizer.php']['selected'] = array(
        //     __('Selected', 'textdomain'),
        //     $menuPermission,
        //     'admin.php?page=event_speech_organizer.php#/selected',
        // );
        // $submenu['event_speech_organizer.php']['waiting'] = array(
        //     __('Waiting', 'textdomain'),
        //     $menuPermission,
        //     'admin.php?page=event_speech_organizer.php#/waiting',
        // );
        // $submenu['event_speech_organizer.php']['rejected'] = array(
        //     __('Rejected', 'textdomain'),
        //     $menuPermission,
        //     'admin.php?page=event_speech_organizer.php#/rejected',
        // );
    }

    public function enqueueAssets()
    {
        do_action('event_speech_organizer/render_admin_app');

        wp_enqueue_script(
            'event_speech_organizer_boot',
            EVENT_SPEECH_ORGANIZER_URL . 'assets/js/boot.js',
            array('jquery'),
            EVENT_SPEECH_ORGANIZER_VERSION,
            true
        );

        // 3rd party developers can now add their scripts here
        do_action('event_speech_organizer/booting_admin_app');
        wp_enqueue_script(
            'event-speech-organizer_js',
            EVENT_SPEECH_ORGANIZER_URL . 'assets/js/plugin-main-js-file.js',
            array('event_speech_organizer_boot'),
            EVENT_SPEECH_ORGANIZER_VERSION,
            true
        );

        //enque css file
        wp_enqueue_style('event-speech-organizer_admin_css', EVENT_SPEECH_ORGANIZER_URL . 'assets/css/element.css');

        $eventSpeechOrganizer = apply_filters('event_speech_organizer/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => EVENT_SPEECH_ORGANIZER_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php'),
            'speakers' => (new ApplicantModel())->getAll(),
        ));

        wp_localize_script('event_speech_organizer_boot', 'eventSpeechOrganizerAdmin', $eventSpeechOrganizer);
    }
}
