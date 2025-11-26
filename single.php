<?php
/**
 * Single post template.
 *
 * @package AlOmran
 */

get_header();
?>

<div class="min-h-screen py-12 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('animate-fade-in-up'); ?>>
                <header class="mb-8">
                    <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                        <?php if (get_the_category()) : ?>
                            <span>•</span>
                            <?php the_category(', '); ?>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="text-4xl font-bold text-primary mb-4"><?php the_title(); ?></h1>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mt-6 rounded-xl overflow-hidden shadow-lg">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-8">
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

                <footer class="border-t border-gray-200 pt-8 mt-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                                ?>
                                <div class="flex gap-2 flex-wrap">
                                    <?php foreach ($tags as $tag) : ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-secondary hover:text-white transition">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </footer>
            </article>

            <?php
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('السابق:', 'alomran') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('التالي:', 'alomran') . '</span> <span class="nav-title">%title</span>',
                )
            );
            ?>

        <?php endwhile; ?>
    </div>
</div>

<?php
get_footer();
