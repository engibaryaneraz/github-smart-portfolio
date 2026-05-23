<?php
/**
 * Plugin Name: GitHub Smart Portfolio
 * Description: Display your GitHub repositories as a portfolio in WordPress.
 * Version: 1.0.0
 * Author: Eraz
 * Text Domain: github-smart-portfolio
 */

if (!defined('ABSPATH')) {
    exit;
}

define('GSP_PATH', plugin_dir_path(__FILE__));
define('GSP_URL', plugin_dir_url(__FILE__));

require_once GSP_PATH . 'includes/class-gsp-loader.php';

function gsp_run_plugin() {
    $loader = new GSP_Loader();
    $loader->run();
}
add_action('plugins_loaded', 'gsp_run_plugin');
