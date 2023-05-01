<?php

namespace speakers\Classes;

use speakers\Classes\ApplicantModel;

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

        $title = __('speakers', 'textdomain');
        global $submenu;
        add_menu_page(
            $title,
            $title,
            $menuPermission,
            'speakers.php',
            array($this, 'enqueueAssets'),
            'dashicons-admin-site',
            25
        );

        $submenu['speakers.php']['applicants'] = array(
            __('Applicants', 'textdomain'),
            $menuPermission,
            'admin.php?page=speakers.php#/',
        );
        $submenu['speakers.php']['selected'] = array(
            __('Selected', 'textdomain'),
            $menuPermission,
            'admin.php?page=speakers.php#/selected',
        );
        $submenu['speakers.php']['waiting'] = array(
            __('Waiting', 'textdomain'),
            $menuPermission,
            'admin.php?page=speakers.php#/waiting',
        );
        $submenu['speakers.php']['rejected'] = array(
            __('Rejected', 'textdomain'),
            $menuPermission,
            'admin.php?page=speakers.php#/rejected',
        );
    }

    public function enqueueAssets()
    {
        do_action('speakers/render_admin_app');
        wp_enqueue_script(
            'speakers_boot',
            SPEAKERS_URL . 'assets/js/boot.js',
            array('jquery'),
            SPEAKERS_VERSION,
            true
        );

        // 3rd party developers can now add their scripts here
        do_action('speakers/booting_admin_app');
        wp_enqueue_script(
            'speakers_js',
            SPEAKERS_URL . 'assets/js/plugin-main-js-file.js',
            array('speakers_boot'),
            SPEAKERS_VERSION,
            true
        );

        //enque css file
        wp_enqueue_style('speakers_admin_css', SPEAKERS_URL . 'assets/css/element.css');

        $speakersAdminVars = apply_filters('speakers/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => SPEAKERS_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php'),
            'speakers' => (new ApplicantModel())->getAll(),
        ));

        wp_localize_script('speakers_boot', 'speakersAdmin', $speakersAdminVars);
    }
}
