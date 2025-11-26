# Theme Setup Checklist

Follow these steps to set up the Al-Omran Industries WordPress theme:

## ✅ Pre-Installation

- [ ] WordPress 5.0+ installed
- [ ] PHP 7.4+ configured
- [ ] MySQL 5.6+ database ready
- [ ] FTP/cPanel access to WordPress installation

## ✅ Installation Steps

### 1. Install Theme
- [ ] Upload `alomran-theme` folder to `/wp-content/themes/`
- [ ] Activate theme in Appearance → Themes
- [ ] Verify theme activation

### 2. Install Required Plugins
- [ ] Install "Advanced Custom Fields" plugin
- [ ] Activate ACF plugin
- [ ] Verify ACF is working (should see ACF menu in admin)

### 3. Configure WordPress Settings
- [ ] Go to Settings → Permalinks
- [ ] Select "Post name" permalink structure
- [ ] Click "Save Changes"

### 4. Create Required Pages
Create the following pages (Pages → Add New):
- [ ] **About** - Use template: "About Page"
- [ ] **Contact** - Use template: "Contact Page"
- [ ] **FAQ** - Use template: "FAQ Page"
- [ ] (Optional) **Home** - Use template: "Default Template" or leave blank

### 5. Set Home Page
- [ ] Go to Settings → Reading
- [ ] Select "A static page"
- [ ] Set "Homepage" to your front page (or create one)
- [ ] Click "Save Changes"

### 6. Create Sample Content

#### Products (Custom Post Type)
- [ ] Create at least 3 products:
  - Navigate to Products → Add New
  - Fill in title, content, featured image
  - Set ACF fields:
    - Short Description
    - Price (e.g., "تواصل للسعر")
    - Product Category (select one)
    - Add Features (repeater field)
    - Add Specifications (repeater field)
    - Set "Is Featured" if desired
  - Publish

#### News (Custom Post Type)
- [ ] Create at least 2-3 news items:
  - Navigate to News → Add New
  - Fill in title, content, featured image
  - Add summary in ACF field
  - Set category (optional)
  - Publish

#### Testimonials (Custom Post Type)
- [ ] Create 2-3 testimonials:
  - Navigate to Testimonials → Add New
  - Title: Person's name
  - Content: Testimonial text
  - Add featured image (avatar)
  - Fill ACF fields: Role, Company, Content
  - Publish

#### FAQ (Custom Post Type)
- [ ] Create 4-5 FAQs:
  - Navigate to FAQ → Add New
  - Title: Question
  - Content: Answer
  - Publish

### 7. Configure Company Information
- [ ] Edit `functions.php` and update `alomran_get_company_info()` function
- [ ] Or use WordPress Customizer (if theme supports it)
- [ ] Update: Name, Slogan, Vision, Mission, Phone, Email, Address

### 8. Customize Menus
- [ ] Go to Appearance → Menus
- [ ] Create a new menu (if needed)
- [ ] Add pages: Home, Products, About, News, FAQ, Contact
- [ ] Assign to "Primary Menu" location
- [ ] Save

### 9. Upload Assets (if needed)
- [ ] Replace placeholder images with actual product images
- [ ] Upload logo (if custom logo is needed)
- [ ] Verify images are displaying correctly

### 10. Test Functionality
- [ ] Test homepage displays correctly
- [ ] Test products archive page
- [ ] Test single product page
- [ ] Test contact form submission
- [ ] Test FAQ accordion
- [ ] Test mobile menu
- [ ] Test chat widget (basic functionality)
- [ ] Test responsive design on mobile/tablet

## 🔧 Optional Configuration

### Chat Widget AI Integration
- [ ] Get API key from AI service (Google Gemini, OpenAI, etc.)
- [ ] Edit `alomran_handle_chat_message()` in `functions.php`
- [ ] Add API integration code
- [ ] Test chat widget with AI responses

### SEO Configuration
- [ ] Install SEO plugin (Yoast SEO, Rank Math, etc.)
- [ ] Configure meta descriptions
- [ ] Set up XML sitemap
- [ ] Verify schema markup

### Performance Optimization
- [ ] Install caching plugin (WP Super Cache, W3 Total Cache)
- [ ] Optimize images
- [ ] Enable GZIP compression
- [ ] Minify CSS/JS (optional - Tailwind is already minified)

### Security
- [ ] Install security plugin (Wordfence, Sucuri)
- [ ] Change default admin username
- [ ] Use strong passwords
- [ ] Enable SSL certificate
- [ ] Regular backups configured

## 📝 Sample Data Structure

### Product Example
- **Title**: جريلات صرف ستانلس ستيل ٣٠٤
- **Short Description**: جريلات عالية التحمل مقاومة للصدأ للمطابخ والمصانع
- **Full Description**: تتميز جريلات الصرف المصنوعة من الستانلس ستيل ٣٠٤...
- **Price**: تواصل للسعر
- **Category**: DRAIN_GRILLS
- **Features**:
  - مقاومة للصدأ (SS304)
  - سلة مخلفات داخلية
  - تصميم مانع للروائح
- **Specifications**:
  - المادة: Stainless Steel 304
  - الأبعاد: 30x30 سم / 50x50 سم

### News Example
- **Title**: المشاركة في معرض 'بيج 5' للبناء
- **Summary**: تتشرف شركة العمران بدعوتكم لزيارة جناحنا...
- **Category**: أخبار الشركة
- **Date**: [Set publication date]

## 🐛 Troubleshooting

### Theme Not Appearing
- Check file permissions
- Verify theme folder is in `/wp-content/themes/`
- Check PHP version (7.4+)

### ACF Fields Not Showing
- Verify ACF plugin is installed and activated
- Check that fields are registered in `functions.php`
- Clear any caching

### Styles Not Loading
- Check browser console for errors
- Verify Tailwind CDN is accessible
- Clear browser cache

### Images Not Displaying
- Check image file paths
- Verify featured images are set
- Check file permissions

## 📞 Support

If you encounter issues:
1. Check WordPress error logs
2. Verify all requirements are met
3. Contact support: info@alomran-eg.com

## ✅ Post-Setup Verification

After setup, verify:
- [ ] All pages are accessible
- [ ] Products display correctly
- [ ] Contact form sends emails
- [ ] Mobile menu works
- [ ] Footer displays company info correctly
- [ ] All links work
- [ ] Images load properly
- [ ] Site is responsive

---

**Theme Version**: 1.0.0
**Last Updated**: 2024

