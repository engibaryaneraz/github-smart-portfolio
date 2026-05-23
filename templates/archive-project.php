<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

    <div class="gsp-archive">
        <h1><?php esc_html_e('Projects', 'github-smart-portfolio'); ?></h1>

        <?php if (have_posts()) : ?>
            <div class="gsp-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php include GSP_PATH . 'templates/project-card.php'; ?>
                <?php endwhile; ?>
            </div>

            <div class="gsp-pagination">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => __('« Previous', 'github-smart-portfolio'),
                    'next_text' => __('Next »', 'github-smart-portfolio'),
                ]);
                ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e('No projects found.', 'github-smart-portfolio'); ?></p>
        <?php endif; ?>
    </div>

<?php
get_footer();
