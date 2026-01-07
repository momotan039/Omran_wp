<?php
/**
 * Download Images from Unsplash for Food Preset Demo
 * 
 * This script downloads images from Unsplash URLs matching the React app
 * and saves them to the media folder with the correct filenames.
 * 
 * Usage: Run via browser or WP-CLI after setting up the demo content
 * 
 * @package AlOmran
 * @subpackage Food
 */

// Load WordPress
if (!defined('ABSPATH')) {
    $wp_load_paths = array(
        __DIR__ . '/../../../../../../wp-load.php',
        __DIR__ . '/../../../../../wp-load.php',
        __DIR__ . '/../../../../wp-load.php',
    );
    
    $wp_loaded = false;
    foreach ($wp_load_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $wp_loaded = true;
            break;
        }
    }
    
    if (!$wp_loaded) {
        die('WordPress not found. Please run this from WordPress admin or ensure wp-load.php is accessible.');
    }
}

// Check permissions
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

// Image mapping from React app constants
$image_map = array(
    // Menu Items - Starters
    'menu-truffle-hummus.jpg' => 'https://i.ytimg.com/vi/dyQA3jzzgsc/maxresdefault.jpg',
    'menu-kibbeh.jpg' => 'https://www.mushroomcouncil.org/wp-content/uploads/2023/07/Mushroom-Kibbeh.jpg',
    'menu-fattoush.jpg' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800&auto=format&fit=crop',
    'menu-vine-leaves.jpg' => 'https://cdn77-s3.lazycatkitchen.com/wp-content/uploads/2020/07/vegan-stuffed-grape-leaves-portion-800x1200.jpg',
    'menu-baba-ghanoush.jpg' => 'https://littleferrarokitchen.com/wp-content/uploads/2023/06/authentic-baba-ganoush-dip.jpg.jpg',
    
    // Menu Items - Mains
    'menu-cherry-kebab.jpg' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=800&auto=format&fit=crop',
    'menu-lamb-ouzi.jpg' => 'https://www.listmag.com/_next/image?url=https%3A%2F%2Fwebcms.listmag.com%2Flistmag%2Fuploads%2Fimages%2F2025%2F03%2F12%2F2174306.webp&w=3840&q=75',
    'menu-mansaf.jpg' => 'https://amiraspantry.com/wp-content/uploads/2021/04/mansaf-I.jpg',
    'menu-sayadieh.jpg' => 'https://urbanfarmandkitchen.com/wp-content/uploads/2023/12/Sayadieh-fish-and-rice-7.jpg',
    'menu-mixed-grill.jpg' => 'https://ohmydish.com/r?url=https%3A%2F%2Fomd-com-files.ams3.digitaloceanspaces.com%2Fwp-content%2Fuploads%2F2020%2F01%2FGreek-mixed-grill.jpg&format=webp&width=1200&height=800&quality=80',
    'menu-lamb-chops.jpg' => 'https://www.chilesandsmoke.com/wp-content/uploads/2022/11/Barbacoa-Lamb-Chops_Featured.jpg',
    'menu-maqluba.jpg' => 'https://www.hungrypaprikas.com/wp-content/uploads/2021/04/Maqluba-New-2-1024x1536.jpg',
    
    // Menu Items - Desserts
    'menu-baklava.jpg' => 'https://idsb.tmgrup.com.tr/ly/uploads/images/2022/03/14/190495.jpg',
    'menu-kunafa.jpg' => 'https://everylittlecrumb.com/wp-content/uploads/kunafa-lift-pic1-scaled.jpg',
    'menu-um-ali.jpg' => 'https://sallycooksart.com/cdn/shop/articles/E2BFF6B9-BB25-48C3-BA06-5689E5279353_2.jpg?v=1649873439',
    'menu-rice-pudding.jpg' => 'https://i.ytimg.com/vi/g56PMuSj2sc/hq720.jpg',
    
    // Menu Items - Drinks
    'menu-lemonade.jpg' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=800&auto=format&fit=crop',
    'menu-saudi-coffee.jpg' => 'https://lh7-rt.googleusercontent.com/docsz/AD_4nXc3C05mktHEbK0mhy2jk7ukJ6WRzyX-X38uQXvZaHiU9EyFKAelQjYl8E0GQ5a3kYU9KHVUKD5XIA6zL7JlVmMVIz6AG2JcyBKf5S0VlukxKTpJW3VmQFnigl3UoVEQPYIq3E7SpQ?key=KI33hpmt2NEclw-Eex3ZKrcx',
    'menu-moroccan-tea.jpg' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?q=80&w=800&auto=format&fit=crop',
    'menu-pomegranate.jpg' => 'https://mf.b37mrtl.ru/media/pics/2023.12/original/658eacd34c59b702a1321da9.jpg',
    
    // Blog Posts
    'blog-spices.jpg' => 'https://images.unsplash.com/photo-1506368249639-73a05d6f6488?q=80&w=1000&auto=format&fit=crop',
    'blog-hospitality.jpg' => 'https://pihospitalityacademy.com/wp-content/uploads/2022/04/WhatsApp-Image-2022-04-20-at-9.51.33-AM-3.jpeg',
    
    // Branches
    'branch-riyadh.jpg' => 'https://images.unsplash.com/photo-1590846406792-0adc7f938f1d?q=80&w=1200&auto=format&fit=crop',
    'branch-jeddah.jpg' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1200&auto=format&fit=crop',
    'branch-dubai.jpg' => 'https://media.cntraveler.com/photos/6552529223a4e79d7a080473/master/w_1600%2Cc_limit/Ninive.jpg',
    
    // Story Page
    'story-image.jpg' => 'https://www.nudge.com.sg/wp-content/uploads/2024/04/dian-lao-er-banner-food-photography-menu-design.webp',
    
    // Static Homepage Images
    'hero-background.jpg' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1920&auto=format&fit=crop',
    'philosophy-image.jpg' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1200&auto=format&fit=crop',
    'story-section-image.jpg' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1200&auto=format&fit=crop',
    
    // Experience Page
    'experience-background.jpg' => 'https://www.properties.market/ae/blog/wp-content/uploads/2023/08/Best-Restaurant-Interior-Design-Ideas-for-a-Luxurious-Ambiance.png',
);

$media_dir = __DIR__ . '/media';
if (!file_exists($media_dir)) {
    wp_mkdir_p($media_dir);
}

echo "<h1>Downloading Images for Food Preset Demo</h1>";
echo "<p>This script will download images from Unsplash and save them to the media folder.</p>";

$downloaded = 0;
$errors = array();

foreach ($image_map as $filename => $url) {
    $file_path = $media_dir . '/' . $filename;
    
    // Skip if already exists
    if (file_exists($file_path)) {
        echo "<p style='color: orange;'>⏭ Skipping {$filename} (already exists)</p>";
        continue;
    }
    
    echo "<p>⬇ Downloading {$filename}...</p>";
    
    // Download image
    $response = wp_remote_get($url, array(
        'timeout' => 30,
        'sslverify' => false,
    ));
    
    if (is_wp_error($response)) {
        $errors[] = "Failed to download {$filename}: " . $response->get_error_message();
        echo "<p style='color: red;'>✗ Error downloading {$filename}: " . esc_html($response->get_error_message()) . "</p>";
        continue;
    }
    
    $body = wp_remote_retrieve_body($response);
    if (empty($body)) {
        $errors[] = "Empty response for {$filename}";
        echo "<p style='color: red;'>✗ Empty response for {$filename}</p>";
        continue;
    }
    
    // Save file
    $saved = file_put_contents($file_path, $body);
    if ($saved === false) {
        $errors[] = "Failed to save {$filename}";
        echo "<p style='color: red;'>✗ Failed to save {$filename}</p>";
        continue;
    }
    
    $downloaded++;
    echo "<p style='color: green;'>✓ Downloaded {$filename} (" . size_format($saved) . ")</p>";
}

echo "<hr>";
echo "<h2>Summary</h2>";
echo "<p style='color: green; font-size: 18px;'><strong>✓ Downloaded {$downloaded} images</strong></p>";

if (!empty($errors)) {
    echo "<h3>Errors:</h3>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li style='color: red;'>" . esc_html($error) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: green;'><strong>✓ All images downloaded successfully!</strong></p>";
}

echo "<p><a href='" . admin_url('admin.php?page=alomran-demo-import') . "'>← Back to Demo Import</a></p>";

