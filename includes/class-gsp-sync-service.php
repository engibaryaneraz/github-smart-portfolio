<?php

if (!defined('ABSPATH')) {
    exit;
}

class GSP_Sync_Service {

    private $api;

    public function __construct() {
        $this->api = new GSP_Github_API();
    }

    public function register_cron() {
        add_action('gsp_sync_event', [$this, 'sync']);

        if (!wp_next_scheduled('gsp_sync_event')) {
            wp_schedule_event(time(), 'hourly', 'gsp_sync_event');
        }

        register_deactivation_hook(GSP_PATH . 'github-smart-portfolio.php', [$this, 'deactivate']);
    }

    public function deactivate() {
        $timestamp = wp_next_scheduled('gsp_sync_event');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'gsp_sync_event');
        }
    }

    public function sync() {
        $username = get_option('gsp_github_username');

        if (!$username) {
            return;
        }

        $repos = $this->api->get_user_repos($username);

        if (!$repos || !is_array($repos)) {
            return;
        }

        foreach ($repos as $repo) {
            if (!isset($repo['name'])) {
                continue;
            }
            $this->import_repo($repo);
        }
    }

    private function import_repo($repo) {
        $title = isset($repo['name']) ? sanitize_text_field($repo['name']) : '';
        if ($title === '') {
            return;
        }

        $existing = get_page_by_title($title, OBJECT, 'project');

        $post_data = [
            'post_title'   => $title,
            'post_content' => isset($repo['description']) ? sanitize_textarea_field($repo['description']) : '',
            'post_status'  => 'publish',
            'post_type'    => 'project',
        ];

        if ($existing) {
            $post_data['ID'] = $existing->ID;
            $post_id = wp_update_post($post_data, true);
        } else {
            $post_id = wp_insert_post($post_data, true);
        }

        if (!$post_id || is_wp_error($post_id)) {
            return;
        }

        update_post_meta($post_id, 'gsp_stars', isset($repo['stargazers_count']) ? (int)$repo['stargazers_count'] : 0);
        update_post_meta($post_id, 'gsp_language', isset($repo['language']) ? sanitize_text_field($repo['language']) : '');
        update_post_meta($post_id, 'gsp_url', isset($repo['html_url']) ? esc_url_raw($repo['html_url']) : '');
        update_post_meta($post_id, 'gsp_forks', isset($repo['forks_count']) ? (int)$repo['forks_count'] : 0);
        update_post_meta($post_id, 'gsp_watchers', isset($repo['watchers_count']) ? (int)$repo['watchers_count'] : 0);
        update_post_meta($post_id, 'gsp_updated_at', isset($repo['updated_at']) ? sanitize_text_field($repo['updated_at']) : '');
    }
}
