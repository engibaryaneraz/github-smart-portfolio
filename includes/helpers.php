<?php

if (!defined('ABSPATH')) {
    exit;
}

function gsp_decode_readme($content) {
    if (!$content || !is_array($content) || !isset($content['content'])) {
        return '';
    }

    $decoded = base64_decode($content['content']);
    if ($decoded === false) {
        return '';
    }

    $decoded = wp_kses_post($decoded);
    return wpautop($decoded);
}

function gsp_safe($value) {
    return esc_html($value ?? '');
}

function gsp_meta($post_id, $key) {
    return get_post_meta($post_id, $key, true);
}

function gsp_format_stars($stars) {
    return number_format_i18n((int)$stars);
}

function gsp_format_date($date_string) {
    if (!$date_string) {
        return '';
    }

    $timestamp = strtotime($date_string);
    if (!$timestamp) {
        return '';
    }

    return date_i18n(get_option('date_format'), $timestamp);
}
