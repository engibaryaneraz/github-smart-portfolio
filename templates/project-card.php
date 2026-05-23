<?php
if (!defined('ABSPATH')) {
    exit;
}

$stars    = gsp_meta(get_the_ID(), 'gsp_stars');
$lang     = gsp_meta(get_the_ID(), 'gsp_language');
$url      = gsp_meta(get_the_ID(), 'gsp_url');
$forks    = gsp_meta(get_the_ID(), 'gsp_forks');
$watchers = gsp_meta(get_the_ID(), 'gsp_watchers');
$updated  = gsp_meta(get_the_ID(), 'gsp_updated_at');
?>

<article class="gsp-card">
    <h3 class="gsp-title">
        <a href="<?php the_permalink(); ?>">
            <?php echo gsp_safe(get_the_title()); ?>
        </a>
    </h3>

    <p class="gsp-excerpt">
        <?php echo gsp_safe(get_the_excerpt()); ?>
    </p>

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
                <?php esc_html_e('View on GitHub', 'github-smart-portfolio'); ?>
            </a>
        <?php endif; ?>
    </div>
</article>
