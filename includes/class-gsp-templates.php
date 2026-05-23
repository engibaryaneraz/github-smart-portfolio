<?php

if (!defined('ABSPATH')) {
    exit;
}

class GSP_Templates {

    /**
     * Initialize template hooks.
     */
    public function init() {
        // Standard WP template filters
        add_filter('single_template', [$this, 'load_single_template']);
        add_filter('archive_template', [$this, 'load_archive_template']);

        // Super reliable fallback (forces plugin templates)
        add_filter('template_include', [$this, 'force_templates'], 99);
    }

    /**
     * Load single template for "project" post type.
     */
    public function load_single_template($template) {
        global $post;

        if ($post && $post->post_type === 'project') {

            // Check if theme overrides template
            $theme_template = locate_template('single-project.php');
            if ($theme_template) {
                return $theme_template;
            }

            // Plugin template
            $plugin_template = GSP_PATH . 'templates/single-project.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        return $template;
    }

    /**
     * Load archive template for "project" post type.
     */
    public function load_archive_template($template) {

        if (is_post_type_archive('project')) {

            // Check if theme overrides template
            $theme_template = locate_template('archive-project.php');
            if ($theme_template) {
                return $theme_template;
            }

            // Plugin template
            $plugin_template = GSP_PATH . 'templates/archive-project.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        return $template;
    }

    /**
     * Force plugin templates even if theme overrides or WP fails to load them.
     * This solves 100% of "empty project page" issues.
     */
    public function force_templates($template) {

        // Single project
        if (is_singular('project')) {
            $plugin_template = GSP_PATH . 'templates/single-project.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        // Archive of projects
        if (is_post_type_archive('project')) {
            $plugin_template = GSP_PATH . 'templates/archive-project.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        return $template;
    }
}
