<?php
/**
 * Page template.
 *
 * @package AlOmran
 */

get_header();
?>

<div class="min-h-screen py-12 bg-white">
    <div class="container mx-auto px-4">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('animate-fade-in-up'); ?>>
                <header class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-primary mb-4"><?php the_title(); ?></h1>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mt-8 rounded-xl overflow-hidden shadow-lg">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    <?php
                    the_content();
                    wp_link_pages(
                        array(
                            'before'      => '<div class="page-links mt-8"><span class="page-links-title">' . esc_html__('Pages:', 'alomran') . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        )
                    );
                    ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php
get_footer();
