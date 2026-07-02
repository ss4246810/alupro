<?php
/**
 * Theme setup and helpers.
 *
 * @package AluProDynamic
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Theme Setup Configuration.
 *
 * - Called by: WordPress core (hooked to 'after_setup_theme' action).
 * - Related Files: Enqueued during initialization, configures global theme behavior.
 * - Purpose: Registers theme support for HTML5, custom-logo, title-tag, post-thumbnails,
 *   and registers navigation menu locations (Primary Navigation & Footer Navigation).
 */
function alupro_dynamic_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support(
		'custom-logo',
		array(
			'height' => 64,
			'width' => 220,
			'flex-height' => true,
			'flex-width' => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __('Primary Navigation', 'alupro-dynamic'),
			'footer' => __('Footer Navigation', 'alupro-dynamic'),
		)
	);
}
add_action('after_setup_theme', 'alupro_dynamic_setup');

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

/**
 * Enqueue Theme Stylesheets and Scripts.
 *
 * - Called by: WordPress core (hooked to 'wp_enqueue_scripts' action).
 * - Related Files: header.php (via wp_head()) and footer.php (via wp_footer()).
 * - Purpose: Enqueues dynamic stylesheets (Google Fonts, Font Awesome, css/style.css, active theme's style.css)
 *   and front-end scripts (Tailwind Play CDN and theme's js/all.js).
 */
function alupro_dynamic_enqueue_assets()
{
	wp_enqueue_style(
		'alupro-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'alupro-font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
		array(),
		'6.0.0-beta3'
	);

	wp_enqueue_script(
		'alupro-tailwind',
		get_theme_file_uri('js/tailwindcss.js'),
		array(),
		filemtime(get_theme_file_path('js/tailwindcss.js')),
		false
	);

	wp_enqueue_style(
		'alupro-design',
		get_theme_file_uri('css/style.css'),
		array('alupro-google-fonts', 'alupro-font-awesome'),
		filemtime(get_theme_file_path('css/style.css'))
	);

	wp_enqueue_style(
		'alupro-theme',
		get_stylesheet_uri(),
		array('alupro-design'),
		filemtime(get_stylesheet_directory() . '/style.css')
	);

	wp_enqueue_script(
		'alupro-scripts',
		get_theme_file_uri('js/all.js'),
		array(),
		filemtime(get_theme_file_path('js/all.js')),
		true
	);
}
add_action('wp_enqueue_scripts', 'alupro_dynamic_enqueue_assets');

/**
 * Register Customizer Settings and Controls.
 *
 * - Called by: WordPress Customizer manager (hooked to 'customize_register' action).
 * - Related Files: template-parts/banner.php (uses the settings registered here).
 * - Purpose: Defines fields for customizer section 'Home Banner' allowing dynamic edits of
 *   eyebrow, title, title accent, description, primary button URL & text, quote button text,
 *   and recommended 1920x1080 resolution background image.
 */
function alupro_dynamic_customize_register($wp_customize)
{
	$wp_customize->add_section(
		'alupro_home_banner',
		array(
			'title' => __('Home Banner', 'alupro-dynamic'),
			'priority' => 30,
		)
	);

	$fields = array(
		'banner_eyebrow' => array('ALUPRO ALLOY | MARINE ALUMINIUM', __('Eyebrow', 'alupro-dynamic'), 'text'),
		'banner_title' => array('Built for the Sea', __('Title', 'alupro-dynamic'), 'text'),
		'banner_title_accent' => array('Engineered for Excellence', __('Title Accent', 'alupro-dynamic'), 'text'),
		'banner_description' => array('Premium marine-grade aluminium alloys for shipbuilding and offshore structures. Full class society certification with immediate stock in Singapore.', __('Description', 'alupro-dynamic'), 'textarea'),
		'banner_primary_text' => array('Download Catalogue', __('Primary Button Text', 'alupro-dynamic'), 'text'),
		'banner_primary_url' => array('#', __('Primary Button URL', 'alupro-dynamic'), 'url'),
		'banner_quote_text' => array('Request a Quote', __('Quote Button Text', 'alupro-dynamic'), 'text'),
	);

	foreach ($fields as $setting_id => $field) {
		$sanitize_callback = 'sanitize_text_field';

		if ('banner_description' === $setting_id) {
			$sanitize_callback = 'sanitize_textarea_field';
		} elseif ('_url' === substr($setting_id, -4)) {
			$sanitize_callback = 'esc_url_raw';
		}

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default' => $field[0],
				'sanitize_callback' => $sanitize_callback,
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label' => $field[1],
				'section' => 'alupro_home_banner',
				'type' => $field[2],
			)
		);
	}

	$wp_customize->add_setting(
		'banner_image',
		array(
			'default' => get_theme_file_uri('images/banner-img-1.webp'),
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'banner_image',
			array(
				'label' => __('Banner Background', 'alupro-dynamic'),
				'description' => __('Recommended size: 1920x1080 pixels.', 'alupro-dynamic'),
				'section' => 'alupro_home_banner',
			)
		)
	);
}
add_action('customize_register', 'alupro_dynamic_customize_register');

/**
 * Generate Static Asset URLs.
 *
 * - Called by: Various template files and fallback functions.
 * - Related Files: header.php, footer.php, template-parts/banner.php, template-parts/about.php.
 * - Purpose: Prepends the active theme's template directory URI to the provided asset path.
 */
function alupro_dynamic_asset_url($path)
{
	return esc_url(get_theme_file_uri(ltrim($path, '/')));
}

/**
 * Get Dynamic Theme Logo URL.
 *
 * - Called by: header.php.
 * - Related Files: header.php.
 * - Purpose: Retrieves the user-customized logo URL from the Customizer.
 *   Falls back to 'images/logo-white.svg' if no custom logo is uploaded.
 */
function alupro_dynamic_get_logo_url()
{
	$custom_logo_id = get_theme_mod('custom_logo');

	if ($custom_logo_id) {
		$logo = wp_get_attachment_image_url($custom_logo_id, 'full');

		if ($logo) {
			return $logo;
		}
	}

	return get_theme_file_uri('images/logo-white.svg');
}

/**
 * Walker Class for Desktop Menu Layout.
 *
 * - Called by: header.php (passed to wp_nav_menu() for 'primary' location).
 * - Related Files: header.php.
 * - Purpose: Extends WordPress Walker_Nav_Menu to output custom HTML and Tailwind utility classes
 *   specific to the desktop dropdown design matching static/index.html navbar structure.
 */
class AluPro_Dynamic_Desktop_Menu_Walker extends Walker_Nav_Menu
{
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		$output .= '<div class="dropdown absolute left-0 top-full w-66 bg-white rounded-xl shadow-xl pt-3 pb-2 border border-[#190E5D]/10 z-50">';
	}

	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		$output .= '</div>';
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$has_children = in_array('menu-item-has-children', $item->classes, true);
		$url = !empty($item->url) ? $item->url : '#';
		$title = apply_filters('the_title', $item->title, $item->ID);

		if (0 === $depth && $has_children) {
			$output .= '<div class="relative group desktop-dropdown-group">';
			$output .= '<button type="button" class="nav-link flex items-center gap-x-1.5 text-white/70 hover:text-[#00a2e0] py-4">';
			$output .= esc_html($title);
			$output .= '<i class="fas fa-chevron-down text-xs text-white/70 transition-transform duration-300 group-hover:rotate-180 group-hover:text-[#00a2e0]"></i>';
			$output .= '</button>';
			return;
		}

		if (0 === $depth) {
			$output .= '<a href="' . esc_url($url) . '" class="nav-link text-white/70 hover:text-[#00a2e0]">' . esc_html($title) . '</a>';
			return;
		}

		$output .= '<a href="' . esc_url($url) . '" class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">' . esc_html($title) . '</a>';
	}

	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {
			$output .= '</div>';
		}
	}
}

/**
 * Walker Class for Mobile Menu Layout.
 *
 * - Called by: header.php (passed to wp_nav_menu() for 'primary' location).
 * - Related Files: header.php.
 * - Purpose: Extends WordPress Walker_Nav_Menu to output custom HTML and Tailwind utility classes
 *   specific to the mobile menu layout matching static/index.html mobile drawer structure.
 */
class AluPro_Dynamic_Mobile_Menu_Walker extends Walker_Nav_Menu
{
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		$output .= '<div class="mobile-dropdown hidden mt-4 ml-4">';
	}

	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		$output .= '</div>';
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$has_children = in_array('menu-item-has-children', $item->classes, true);
		$url = !empty($item->url) ? $item->url : '#';
		$title = apply_filters('the_title', $item->title, $item->ID);

		if (0 === $depth && $has_children) {
			$output .= '<div>';
			$output .= '<button type="button" onclick="toggleMobileDropdown(this)" class="flex items-center justify-between w-full text-left font-semibold text-[#111827]">';
			$output .= esc_html($title);
			$output .= '<i class="fas fa-chevron-down text-[#111827] transition-transform"></i>';
			$output .= '</button>';
			return;
		}

		if (0 === $depth) {
			$output .= '<a href="' . esc_url($url) . '" class="font-semibold text-[#111827]">' . esc_html($title) . '</a>';
			return;
		}

		$output .= '<a href="' . esc_url($url) . '" class="block py-2 text-[#111827]">' . esc_html($title) . '</a>';
	}

	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {
			$output .= '</div>';
		}
	}
}

/**
 * Static Desktop Menu Fallback.
 *
 * - Called by: header.php (used if no 'primary' nav menu is configured in WordPress).
 * - Related Files: header.php.
 * - Purpose: Renders the hardcoded static navigation links for desktop screens, matching static/index.html.
 */
function alupro_dynamic_static_desktop_menu()
{
	?>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">Home</a>
	<a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">About
		Us</a>
	<div class="relative group desktop-dropdown-group">
		<button type="button" class="nav-link flex items-center gap-x-1.5 text-white/70 hover:text-[#00a2e0] py-4">
			Products
			<i
				class="fas fa-chevron-down text-xs text-white/70 transition-transform duration-300 group-hover:rotate-180 group-hover:text-[#00a2e0]"></i>
		</button>
		<div
			class="dropdown absolute left-0 top-full w-66 bg-white rounded-xl shadow-xl pt-3 pb-2 border border-[#190E5D]/10 z-50">
			<a href="#sheets-plates-aluminium"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Marine Grade Aluminium</a>
			<a href="#structural-grade-aluminium"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Structural Grade
				Aluminium</a>
			<a href="#aerospace-grade-aluminium"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Aerospace Grade Aluminium</a>
			<a href="#extrusions-profiles-aluminium"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Extrusions &amp; Profiles
				Aluminium </a>
			<a href="#specialty-range-aluminium"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Specialty Range Aluminium
			</a>
		</div>
	</div>
	<a href="#custom-services" class="nav-link text-white/70 hover:text-[#00a2e0]">Custom Services</a>
	<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">Contact</a>
	<?php
}

/**
 * Static Mobile Menu Fallback.
 *
 * - Called by: header.php (used if no 'primary' nav menu is configured in WordPress).
 * - Related Files: header.php.
 * - Purpose: Renders the hardcoded static navigation links for mobile screens, matching static/index.html.
 */
function alupro_dynamic_static_mobile_menu()
{
	?>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold text-[#111827]">Home</a>
	<a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="font-semibold text-[#111827]">About Us</a>
	<div>
		<button type="button" onclick="toggleMobileDropdown(this)"
			class="flex items-center justify-between w-full text-left font-semibold text-[#111827]">
			Products
			<i class="fas fa-chevron-down text-[#111827] transition-transform"></i>
		</button>
		<div class="mobile-dropdown hidden mt-4 ml-4">
			<a href="#sheets-plates-aluminium" class="block py-2 text-[#111827]">Marine Grade Aluminium</a>
			<a href="#structural-grade-aluminium" class="block py-2 text-[#111827]">Structural Grade Aluminium</a>
			<a href="#aerospace-grade-aluminium" class="block py-2 text-[#111827]">Aerospace Grade Aluminium</a>
			<a href="#extrusions-profiles-aluminium" class="block py-2 text-[#111827]">Extrusions &amp; Profiles
				Aluminium</a>
			<a href="#specialty-range-aluminium" class="block py-2 text-[#111827]">Specialty Range Aluminium</a>
		</div>
	</div>
	<a href="#custom-services" class="font-semibold text-[#111827]">Custom Services</a>
	<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="font-semibold text-[#111827]">Contact</a>
	<?php
}

/**
 * Extract Custom Static Fragment from home-static.html.
 *
 * - Called by: footer.php, aboutus template, contact template, etc.
 * - Related Files: footer.php, templates/home-static.html.
 * - Purpose: Reads the static home template, searches for section markers, extracts the desired HTML chunk,
 *   removes unnecessary static script tags, and rewrites relative image/asset URLs to work dynamically.
 */
function alupro_dynamic_static_fragment($start_marker, $end_marker = '')
{
	$file = get_theme_file_path('templates/home-static.html');

	if (!file_exists($file)) {
		return '';
	}

	$html = file_get_contents($file);
	$start = strpos($html, $start_marker);

	if (false === $start) {
		return '';
	}

	$start += strlen($start_marker);
	$end = $end_marker ? strpos($html, $end_marker, $start) : false;

	if (false === $end) {
		$end = strlen($html);
	}

	$fragment = substr($html, $start, $end - $start);
	$fragment = preg_replace('#<script\s+src=["\']js/all\.js["\']>\s*</script>#i', '', $fragment);
	$fragment = preg_replace('#</?body[^>]*>|</?html[^>]*>#i', '', $fragment);
	$fragment = str_replace(
		array('src="images/', "src='images/", 'href="images/', "href='images/", 'url("images/', "url('images/"),
		array('src="' . esc_url(get_theme_file_uri('images/')), "src='" . esc_url(get_theme_file_uri('images/')), 'href="' . esc_url(get_theme_file_uri('images/')), "href='" . esc_url(get_theme_file_uri('images/')), 'url("' . esc_url(get_theme_file_uri('images/')), "url('" . esc_url(get_theme_file_uri('images/'))),
		$fragment
	);

	return $fragment;
}

/**
 * Extract Non-Dynamic Homepage Content Sections.
 *
 * - Called by: front-page.php.
 * - Related Files: front-page.php, templates/home-static.html.
 * - Purpose: Extracts all homepage sections from the static template between '<!-- About Section Ends -->'
 *   and '<!-- Footer Starts -->'. Dynamically updates asset paths and serves them as a single content fragment.
 */
function alupro_dynamic_static_home_sections()
{
	$file = get_theme_file_path('templates/home-static.html');

	if (!file_exists($file)) {
		return '';
	}

	$html = file_get_contents($file);

	// Start loading static sections after the dynamic product sections end (Specialty Range is the last one)
	$start_pos = strpos($html, '<!-- Specialty Range Aluminium Section Ends -->');
	if (false !== $start_pos) {
		$start_pos += strlen('<!-- Specialty Range Aluminium Section Ends -->');
	} else {
		// Fallback to older markers if specialty range marker is not found
		$start_pos = strpos($html, '<!-- Sheets & Plates Aluminium Section Ends -->');
		if (false !== $start_pos) {
			$start_pos += strlen('<!-- Sheets & Plates Aluminium Section Ends -->');
		} else {
			$start_pos = strpos($html, '<!-- Browse Section Ends -->');
			if (false !== $start_pos) {
				$start_pos += strlen('<!-- Browse Section Ends -->');
			}
		}
	}

	$footer = strpos($html, '<!-- Footer Starts -->');

	if (false === $start_pos || false === $footer) {
		return '';
	}

	$fragment = substr($html, $start_pos, $footer - $start_pos);

	$fragment = str_replace(
		array('src="images/', "src='images/", 'href="images/', "href='images/", 'url("images/', "url('images/"),
		array('src="' . esc_url(get_theme_file_uri('images/')), "src='" . esc_url(get_theme_file_uri('images/')), 'href="' . esc_url(get_theme_file_uri('images/')), "href='" . esc_url(get_theme_file_uri('images/')), 'url("' . esc_url(get_theme_file_uri('images/')), "url('" . esc_url(get_theme_file_uri('images/'))),
		$fragment
	);

	return $fragment;
}

/**
 * Load Modular ACF Fields.
 */
require_once get_template_directory() . '/inc/acf/acf-loader.php';
require_once get_template_directory() . '/inc/product-schedule-pdf.php';


/**
 * Get the About Us Page ID dynamically.
 */
function alupro_get_about_page_id()
{
	// 1. If we are on the About Us page template, use the current page ID
	if (is_page_template('page-about-us.php')) {
		return get_the_ID();
	}

	// 2. Query for pages with the page-about-us.php template
	$pages = get_posts(array(
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-about-us.php',
		'posts_per_page' => 1,
	));

	if (!empty($pages)) {
		return $pages[0]->ID;
	}

	// 3. Fallback: try by slug 'about-us'
	$about_page = get_page_by_path('about-us');
	if ($about_page) {
		return $about_page->ID;
	}

	// 4. Fallback: try by slug 'aboutus'
	$about_page = get_page_by_path('aboutus');
	if ($about_page) {
		return $about_page->ID;
	}

	return null;
}

/**
 * Register CPT: Aluminium Product
 * Register Taxonomy: Product Category
 */
function alupro_dynamic_register_cpts()
{
	// 1. Taxonomy
	$tax_labels = array(
		'name' => _x('Product Categories', 'taxonomy general name', 'alupro-dynamic'),
		'singular_name' => _x('Product Category', 'taxonomy singular name', 'alupro-dynamic'),
		'search_items' => __('Search Product Categories', 'alupro-dynamic'),
		'all_items' => __('All Product Categories', 'alupro-dynamic'),
		'parent_item' => __('Parent Product Category', 'alupro-dynamic'),
		'parent_item_colon' => __('Parent Product Category:', 'alupro-dynamic'),
		'edit_item' => __('Edit Product Category', 'alupro-dynamic'),
		'update_item' => __('Update Product Category', 'alupro-dynamic'),
		'add_new_item' => __('Add New Product Category', 'alupro-dynamic'),
		'new_item_name' => __('New Product Category Name', 'alupro-dynamic'),
		'menu_name' => __('Product Categories', 'alupro-dynamic'),
	);

	$tax_args = array(
		'hierarchical' => true,
		'labels' => $tax_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'product-category'),
		'show_in_rest' => true,
	);

	register_taxonomy('product_category', array('aluminium_product'), $tax_args);

	// 2. Custom Post Type
	$cpt_labels = array(
		'name' => _x('Aluminium Products', 'Post type general name', 'alupro-dynamic'),
		'singular_name' => _x('Aluminium Product', 'Post type singular name', 'alupro-dynamic'),
		'menu_name' => _x('Aluminium Products', 'Admin Menu text', 'alupro-dynamic'),
		'name_admin_bar' => _x('Aluminium Product', 'Add New on Toolbar', 'alupro-dynamic'),
		'add_new' => __('Add New', 'alupro-dynamic'),
		'add_new_item' => __('Add New Aluminium Product', 'alupro-dynamic'),
		'new_item' => __('New Aluminium Product', 'alupro-dynamic'),
		'edit_item' => __('Edit Aluminium Product', 'alupro-dynamic'),
		'view_item' => __('View Aluminium Product', 'alupro-dynamic'),
		'all_items' => __('All Products', 'alupro-dynamic'),
		'search_items' => __('Search Aluminium Products', 'alupro-dynamic'),
		'not_found' => __('No products found.', 'alupro-dynamic'),
		'not_found_in_trash' => __('No products found in Trash.', 'alupro-dynamic'),
	);

	$cpt_args = array(
		'labels' => $cpt_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'product'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-grid-view',
		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
		'show_in_rest' => true,
	);

	register_post_type('aluminium_product', $cpt_args);
}
add_action('init', 'alupro_dynamic_register_cpts');

/**
 * Automatically pre-create taxonomy terms for Product Category taxonomy.
 */
function alupro_dynamic_precreate_categories()
{
	if (!taxonomy_exists('product_category')) {
		return;
	}

	$default_terms = array(
		'Marine Grade' => 'marine-grade',
		'Structural Grade' => 'structural-grade',
		'Aerospace Grade' => 'aerospace-grade',
		'Product Profiles' => 'extrusions-profiles',
		'Specialty Grade' => 'specialty-grade',
	);

	foreach ($default_terms as $name => $slug) {
		if (!term_exists($slug, 'product_category')) {
			wp_insert_term(
				$name,
				'product_category',
				array(
					'slug' => $slug,
				)
			);
		}
	}
}
add_action('init', 'alupro_dynamic_precreate_categories', 15);

/**
 * Register TinyMCE table plugin and add its button to the toolbar.
 */
function alupro_add_tinymce_table_plugin($plugin_array)
{
	$plugin_array['table'] = get_template_directory_uri() . '/js/tinymce/table/plugin.min.js';
	return $plugin_array;
}
add_filter('mce_external_plugins', 'alupro_add_tinymce_table_plugin');

function alupro_add_tinymce_table_button($buttons)
{
	array_push($buttons, 'table');
	return $buttons;
}
add_filter('mce_buttons', 'alupro_add_tinymce_table_button');

/**
 * Register custom stylesheet for TinyMCE visual editor.
 */
function alupro_add_editor_styles()
{
	add_editor_style('css/editor-style.css');
}
add_action('admin_init', 'alupro_add_editor_styles');

/**
 * Set default editor content for new Aluminium Product posts.
 */
function alupro_default_product_editor_content($content, $post)
{
	if ('aluminium_product' === $post->post_type) {
		$content = '
<table>
	<thead>
		<tr>
			<th>Thickness</th>
			<th>Width</th>
			<th>Length</th>
			<th>Availability</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td rowspan="4">3.0mm</td>
			<td>1220 mm</td>
			<td>2440 mm</td>
			<td>Stock</td>
		</tr>
		<tr>
			<td>1500 mm</td>
			<td>6000 mm</td>
			<td>Stock</td>
		</tr>
		<tr>
			<td>2000 mm</td>
			<td>6000 mm</td>
			<td>Stock</td>
		</tr>
		<tr>
			<td>2200 mm</td>
			<td>9000 mm</td>
			<td>Indent</td>
		</tr>
		<tr>
			<td rowspan="4">4.0mm</td>
			<td>1220 mm</td>
			<td>2440 mm</td>
			<td>Stock</td>
		</tr>
		<tr>
			<td>1500 mm</td>
			<td>6000 mm</td>
			<td>Stock</td>
		</tr>
		<tr>
			<td>2000 mm</td>
			<td>6000 mm</td>
			<td>Stock</td>
		</tr>
		<tr>
			<td>2200 mm</td>
			<td>9000 mm</td>
			<td>Indent</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>
';
	}
	return $content;
}
add_filter('default_content', 'alupro_default_product_editor_content', 10, 2);
