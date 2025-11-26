<?php
/**
 * 404 template.
 *
 * @package AlOmran
 */

get_header();
?>

<div class="min-h-screen bg-gray-50 py-20">
    <div class="container mx-auto px-4 text-center">
        <div class="animate-fade-in-up">
            <h1 class="text-8xl font-black text-primary mb-4">404</h1>
            <h2 class="text-3xl font-bold text-gray-800 mb-4"><?php esc_html_e('الصفحة غير موجودة', 'alomran'); ?></h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                <?php esc_html_e('عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.', 'alomran'); ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-green-800 transition shadow-lg inline-block">
                    <?php esc_html_e('العودة للرئيسية', 'alomran'); ?>
                </a>
                <a href="javascript:history.back()" class="border-2 border-primary text-primary px-8 py-3 rounded-lg font-bold hover:bg-primary hover:text-white transition inline-block">
                    <?php esc_html_e('العودة للخلف', 'alomran'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
