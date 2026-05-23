<?php

if (!defined('ABSPATH')) {
    exit;
}

class GSP_Github_API {

    private $api_url = 'https://api.github.com/';
    private $token;

    public function __construct() {
        $this->token = get_option('gsp_github_token');
    }

    private function request($endpoint) {
        $args = [
            'headers' => [
                'User-Agent' => 'WordPress-GSP-Plugin',
                'Accept'     => 'application/vnd.github+json',
            ],
            'timeout' => 15,
        ];

        if ($this->token) {
            $args['headers']['Authorization'] = 'token ' . $this->token;
        }

        $response = wp_remote_get($this->api_url . ltrim($endpoint, '/'), $args);

        if (is_wp_error($response)) {
            return false;
        }

        $code = wp_remote_retrieve_response_code($response);
        if ($code < 200 || $code >= 300) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        if (!$body) {
            return false;
        }

        $data = json_decode($body, true);
        if (!is_array($data)) {
            return false;
        }

        return $data;
    }

    public function get_user_repos($username) {
        $username = trim($username);
        if ($username === '') {
            return false;
        }

        return $this->request("users/{$username}/repos?per_page=100&sort=updated");
    }

    public function get_readme($username, $repo) {
        $username = trim($username);
        $repo     = trim($repo);

        if ($username === '' || $repo === '') {
            return false;
        }

        return $this->request("repos/{$username}/{$repo}/readme");
    }
}
