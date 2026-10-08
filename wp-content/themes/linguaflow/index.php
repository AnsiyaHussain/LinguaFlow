<?php
/**
 * Main Template File Fallback
 */
get_header();
?>

<div class="lf-container" style="padding: 4rem 0;">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('lf-card'); ?>>
                <h1 style="margin-bottom: 1rem;"><?php the_title(); ?></h1>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    else :
        ?>
        <div class="lf-card">
            <h2>Page Not Found</h2>
            <p>The requested page could not be found.</p>
        </div>
        <?php
    endif;
    ?>
</div>

<?php get_footer(); ?>
