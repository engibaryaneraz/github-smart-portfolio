<?php

if (!defined('ABSPATH')) {
    exit;
}

class GSP_Loader {

    public function __construct() {
        require_once GSP_PATH . 'includes/class-gsp-project-cpt.php';
        require_once GSP_PATH . 'includes/class-gsp-github-api.php';
        require_once GSP_PATH . 'includes/class-gsp-sync-service.php';
        require_once GSP_PATH . 'includes/class-gsp-admin-page.php';
        require_once GSP_PATH . 'includes/class-gsp-templates.php';
        require_once GSP_PATH . 'includes/helpers.php';
    }

    public function run() {
        $cpt = new GSP_Project_CPT();
        $cpt->register();

        $admin = new GSP_Admin_Page();
        $admin->init();

        $sync = new GSP_Sync_Service();
        $sync->register_cron();

        $templates = new GSP_Templates();
        $templates->init();

        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'gsp-style',
            GSP_URL . 'assets/css/style.css',
            [],
            '1.0.0'
        );
    }
}
