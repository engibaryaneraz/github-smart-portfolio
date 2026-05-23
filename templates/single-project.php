<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$stars    = gsp_meta(get_the_ID(), 'gsp_stars');
$lang     = gsp_meta(get_the_ID(), 'gsp_language');
$url      = gsp_meta(get_the_ID(), 'gsp_url');
$forks    = gsp_meta(get_the_ID(), 'gsp_forks');
$watchers = gsp_meta(get_the_ID(), 'gsp_watchers');
$updated  = gsp_meta(get_the_ID(), 'gsp_updated_at');

$username = get_option('gsp_github_username');
$api      = new GSP_Github_API();
$readme   = $username ? $api->get_readme($username, get_the_title()) : null;
$readme_html = gsp_decode_readme($readme);
?>

    <div class="gsp-single">
        <h1><?php echo gsp_safe(get_the_title()); ?></h1>

        <div class="gsp-meta">
            <span>⭐ <?php echo gsp_format_stars($stars); ?></span>

            <?php if ($lang) : ?>
                <span>💻 <?php echo gsp_safe($lang); ?></span>
            <?php endif; ?>

            <?php if ($forks) : ?>
                <span>🍴 <?php echo (int)$forks; ?></span>
            <?php endif; ?>

            <?php if ($watchers) : ?>
                <span>👀 <?php echo (int)$watchers; ?></span>
            <?php endif; ?>

            <?php if ($updated) : ?>
                <span>⏱ <?php echo gsp_safe(gsp_format_date($updated)); ?></span>
            <?php endif; ?>

            <?php if ($url) : ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                    <?php esc_html_e('Open on GitHub', 'github-smart-portfolio'); ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="gsp-description">
            <?php the_content(); ?>
        </div>

        <?php if ($readme_html) : ?>
            <h2><?php esc_html_e('README.md', 'github-smart-portfolio'); ?></h2>
            <div class="gsp-readme">
                <?php echo $readme_html; ?>
            </div>
        <?php endif; ?>
    </div>

<?php
get_footer();
