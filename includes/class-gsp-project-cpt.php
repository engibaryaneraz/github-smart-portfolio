<?php

if (!defined('ABSPATH')) {
    exit;
}

class GSP_Project_CPT {

    public function register() {
        add_action('init', [$this, 'register_post_type']);
    }

    public function register_post_type() {
        $labels = [
            'name'               => __('Projects', 'github-smart-portfolio'),
            'singular_name'      => __('Project', 'github-smart-portfolio'),
            'add_new'            => __('Add Project', 'github-smart-portfolio'),
            'add_new_item'       => __('Add New Project', 'github-smart-portfolio'),
            'edit_item'          => __('Edit Project', 'github-smart-portfolio'),
            'new_item'           => __('New Project', 'github-smart-portfolio'),
            'view_item'          => __('View Project', 'github-smart-portfolio'),
            'search_items'       => __('Search Projects', 'github-smart-portfolio'),
            'not_found'          => __('No projects found', 'github-smart-portfolio'),
            'not_found_in_trash' => __('No projects found in Trash', 'github-smart-portfolio'),
            'all_items'          => __('All Projects', 'github-smart-portfolio'),
            'menu_name'          => __('Projects', 'github-smart-portfolio'),
        ];

        $args = [
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-portfolio',
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
            'rewrite'      => ['slug' => 'projects'],
            'show_in_rest' => true,
        ];

        register_post_type('project', $args);
    }
}
