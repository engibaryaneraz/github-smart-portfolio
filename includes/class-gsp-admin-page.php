<?php

if (!defined('ABSPATH')) {
    exit;
}

class GSP_Admin_Page {

    public function init() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_menu() {
        add_menu_page(
            __('GitHub Portfolio', 'github-smart-portfolio'),
            __('GitHub Portfolio', 'github-smart-portfolio'),
            'manage_options',
            'gsp-settings',
            [$this, 'render_page'],
            'dashicons-admin-generic'
        );
    }

    public function register_settings() {
        register_setting('gsp_settings_group', 'gsp_github_username', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ]);

        register_setting('gsp_settings_group', 'gsp_github_token', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ]);
    }

    public function render_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (isset($_POST['gsp_manual_sync']) && check_admin_referer('gsp_manual_sync_action', 'gsp_manual_sync_nonce')) {
            $sync = new GSP_Sync_Service();
            $sync->sync();
            echo '<div class="updated notice is-dismissible"><p>' . esc_html__('Sync completed.', 'github-smart-portfolio') . '</p></div>';
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('GitHub Smart Portfolio', 'github-smart-portfolio'); ?></h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('gsp_settings_group');
                do_settings_sections('gsp_settings_group');
                ?>

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="gsp_github_username"><?php esc_html_e('GitHub Username', 'github-smart-portfolio'); ?></label>
                        </th>
                        <td>
                            <input type="text"
                                   id="gsp_github_username"
                                   name="gsp_github_username"
                                   value="<?php echo esc_attr(get_option('gsp_github_username')); ?>"
                                   class="regular-text">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="gsp_github_token"><?php esc_html_e('GitHub Personal Access Token', 'github-smart-portfolio'); ?></label>
                        </th>
                        <td>
                            <input type="text"
                                   id="gsp_github_token"
                                   name="gsp_github_token"
                                   value="<?php echo esc_attr(get_option('gsp_github_token')); ?>"
                                   class="regular-text">
                            <p class="description">
                                <?php esc_html_e('Optional but recommended. Increases API rate limits and allows private repos if configured.', 'github-smart-portfolio'); ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(__('Save Settings', 'github-smart-portfolio')); ?>
            </form>

            <hr>

            <form method="post">
                <?php wp_nonce_field('gsp_manual_sync_action', 'gsp_manual_sync_nonce'); ?>
                <input type="hidden" name="gsp_manual_sync" value="1">
                <?php submit_button(__('Sync Now', 'github-smart-portfolio'), 'secondary'); ?>
            </form>
        </div>
        <?php
    }
}
