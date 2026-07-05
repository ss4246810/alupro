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
			'footer_1' => __('Footer 1 Menu', 'alupro-dynamic'),
			'footer_2' => __('Footer 2 Menu', 'alupro-dynamic'),
			'footer_3' => __('Footer 3 Menu', 'alupro-dynamic'),
			'footer_legal' => __('Footer Legal Menu', 'alupro-dynamic'),
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
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
		array(),
		'6.5.2'
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
 * URL for the homepage Custom Services section.
 */
function alupro_dynamic_custom_services_anchor_url()
{
	return home_url('/#custom-services');
}

/**
 * Stable homepage anchor IDs for product categories.
 */
function alupro_dynamic_product_category_anchor_id($term)
{
	$slug = is_object($term) && isset($term->slug) ? $term->slug : (string) $term;
	$slug = sanitize_title($slug);

	$anchors = array(
		'marine-grade' => 'sheets-plates-aluminium',
		'structural-grade' => 'structural-grade-aluminium',
		'aerospace-grade' => 'aerospace-grade-aluminium',
		'extrusions-profiles' => 'extrusions-profiles-aluminium',
		'specialty-grade' => 'specialty-range-aluminium',
	);

	if (isset($anchors[$slug])) {
		return $anchors[$slug];
	}

	return 'product-category-' . $slug;
}

/**
 * Homepage URL for one product category section.
 */
function alupro_dynamic_product_category_anchor_url($term)
{
	return home_url('/#' . alupro_dynamic_product_category_anchor_id($term));
}

/**
 * Treat selected menu items as homepage section links even when an admin menu is assigned.
 */
function alupro_dynamic_menu_item_points_to_custom_services($item)
{
	$title = isset($item->title) ? sanitize_title($item->title) : '';
	$url = isset($item->url) ? (string) $item->url : '';
	$path = (string) wp_parse_url($url, PHP_URL_PATH);

	return false !== strpos($title, 'custom-services') || false !== strpos($path, '/custom-services');
}

/**
 * Keep manually added product category menu items pointing at homepage sections.
 */
function alupro_dynamic_menu_item_product_category_anchor($item)
{
	if (isset($item->object, $item->object_id) && 'product_category' === $item->object) {
		$term = get_term((int) $item->object_id, 'product_category');
		if ($term && !is_wp_error($term)) {
			return alupro_dynamic_product_category_anchor_url($term);
		}
	}

	$url = isset($item->url) ? (string) $item->url : '';
	$path = trim((string) wp_parse_url($url, PHP_URL_PATH), '/');
	if (0 === strpos($path, 'product-category/')) {
		$slug = basename($path);
		$term = get_term_by('slug', $slug, 'product_category');
		if ($term && !is_wp_error($term)) {
			return alupro_dynamic_product_category_anchor_url($term);
		}
	}

	$aliases = array(
		'marine-grade-aluminium' => 'marine-grade',
		'structural-grade-aluminium' => 'structural-grade',
		'aerospace-grade-aluminium' => 'aerospace-grade',
		'extrusions-profiles-aluminium' => 'extrusions-profiles',
		'specialty-range-aluminium' => 'specialty-grade',
	);
	$title_slug = isset($item->title) ? sanitize_title($item->title) : '';
	$path_slug = basename($path);

	foreach (array($title_slug, $path_slug) as $candidate) {
		if (isset($aliases[$candidate])) {
			return alupro_dynamic_product_category_anchor_url($aliases[$candidate]);
		}
	}

	return '';
}

/**
 * Normalize URLs for manually managed menu items.
 */
function alupro_dynamic_filter_nav_menu_objects($items, $args)
{
	foreach ($items as $item) {
		if (alupro_dynamic_menu_item_points_to_custom_services($item)) {
			$item->url = alupro_dynamic_custom_services_anchor_url();
		}

		$product_category_url = alupro_dynamic_menu_item_product_category_anchor($item);
		if ($product_category_url) {
			$item->url = $product_category_url;
		}
	}

	return $items;
}
add_filter('wp_nav_menu_objects', 'alupro_dynamic_filter_nav_menu_objects', 20, 2);

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
 * Walker Class for Footer Menu Layout.
 */
class AluPro_Dynamic_Footer_Menu_Walker extends Walker_Nav_Menu
{
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		$output .= '<ul class="mt-3 ml-4 space-y-3">';
	}

	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		$output .= '</ul>';
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$url = !empty($item->url) ? $item->url : '#';
		$title = apply_filters('the_title', $item->title, $item->ID);

		$output .= '<li>';
		$output .= '<a href="' . esc_url($url) . '" class="transition-colors hover:text-[#00a2e0]">' . esc_html($title) . '</a>';
	}

	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output .= '</li>';
	}
}

/**
 * Default footer settings.
 */
function alupro_dynamic_footer_setting_defaults()
{
	return array(
		'description' => 'Singapore-based aluminium stockist supplying certified marine, engineering, semiconductor, and aerospace materials with reliable traceability.',
		'mailing_address' => "Mailing address:\n8 Burn Road #11-03 Trivex Singapore 369977.",
		'warehouse_address' => "Warehouse:\nBenoi Road, Singapore",
		'footer_1_title' => 'Company',
		'footer_2_title' => 'Products',
		'footer_3_title' => 'Services',
		'contact_title' => 'Get In Touch',
		'phone' => '+65 6876 1198',
		'email' => 'info@aluproalloy.com',
		'fax' => '+65 6876 1197',
		'hours' => 'Mon - Fri (9:00 AM - 6:00 PM)',
		'linkedin_url' => '#',
		'facebook_url' => '#',
		'x_url' => '#',
		'copyright' => 'Copyright 2026 AluPro Alloy Solutions Pte Ltd. All rights reserved.',
	);
}

/**
 * Get merged footer settings.
 */
function alupro_dynamic_get_footer_settings()
{
	$defaults = alupro_dynamic_footer_setting_defaults();
	$stored = get_option('alupro_dynamic_footer_settings', array());

	if (!is_array($stored)) {
		$stored = array();
	}

	return wp_parse_args($stored, $defaults);
}

/**
 * Render footer text with line breaks.
 */
function alupro_dynamic_footer_text($value)
{
	echo nl2br(esc_html($value));
}

/**
 * Build a phone href from a display value.
 */
function alupro_dynamic_phone_href($phone)
{
	$phone = preg_replace('/[^0-9+]/', '', (string) $phone);

	return $phone ? 'tel:' . $phone : '#';
}

/**
 * Render a footer menu location with fallback links.
 */
function alupro_dynamic_footer_menu($theme_location, $fallback_items = array(), $legacy_location = '', $list_class = 'mt-6 space-y-4 text-sm font-medium text-[#D8DAEA]')
{
	$location = $theme_location;

	if (!has_nav_menu($location) && $legacy_location && has_nav_menu($legacy_location)) {
		$location = $legacy_location;
	}

	if (has_nav_menu($location)) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container' => false,
				'items_wrap' => '<ul class="' . esc_attr($list_class) . '">%3$s</ul>',
				'walker' => new AluPro_Dynamic_Footer_Menu_Walker(),
				'fallback_cb' => false,
			)
		);
		return;
	}

	if (empty($fallback_items)) {
		return;
	}

	echo '<ul class="' . esc_attr($list_class) . '">';
	foreach ($fallback_items as $item) {
		$url = isset($item['url']) ? $item['url'] : '#';
		$label = isset($item['label']) ? $item['label'] : '';

		if ('' === $label) {
			continue;
		}

		echo '<li><a href="' . esc_url($url) . '" class="transition-colors hover:text-[#00a2e0]">' . esc_html($label) . '</a></li>';
	}
	echo '</ul>';
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
			<a href="<?php echo esc_url(home_url('/#sheets-plates-aluminium')); ?>"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Marine Grade Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#structural-grade-aluminium')); ?>"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Structural Grade
				Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#aerospace-grade-aluminium')); ?>"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Aerospace Grade Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#extrusions-profiles-aluminium')); ?>"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Extrusions &amp; Profiles
				Aluminium </a>
			<a href="<?php echo esc_url(home_url('/#specialty-range-aluminium')); ?>"
				class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Specialty Range Aluminium
			</a>
		</div>
	</div>
	<a href="<?php echo esc_url(alupro_dynamic_custom_services_anchor_url()); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">Custom Services</a>
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
			<a href="<?php echo esc_url(home_url('/#sheets-plates-aluminium')); ?>" class="block py-2 text-[#111827]">Marine Grade Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#structural-grade-aluminium')); ?>" class="block py-2 text-[#111827]">Structural Grade Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#aerospace-grade-aluminium')); ?>" class="block py-2 text-[#111827]">Aerospace Grade Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#extrusions-profiles-aluminium')); ?>" class="block py-2 text-[#111827]">Extrusions &amp; Profiles
				Aluminium</a>
			<a href="<?php echo esc_url(home_url('/#specialty-range-aluminium')); ?>" class="block py-2 text-[#111827]">Specialty Range Aluminium</a>
		</div>
	</div>
	<a href="<?php echo esc_url(alupro_dynamic_custom_services_anchor_url()); ?>" class="font-semibold text-[#111827]">Custom Services</a>
	<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="font-semibold text-[#111827]">Contact</a>
	<?php
}

/**
 * Get a safe frontend redirect URL after form submission.
 */
function alupro_dynamic_form_redirect_url($status_key, $status_value)
{
	$redirect_to = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url('/');
	$redirect_to = wp_validate_redirect($redirect_to, home_url('/'));
	$redirect_to = remove_query_arg(array('alupro_subscribe', 'alupro_enquiry', 'alupro_contact'), $redirect_to);

	return add_query_arg($status_key, $status_value, $redirect_to);
}

/**
 * Resolve the dynamic WordPress admin email for frontend form notifications.
 */
function alupro_dynamic_form_recipient_email()
{
	$email = sanitize_email(get_option('admin_email'));

	return $email ? $email : sanitize_email('info@aluproalloy.com');
}

/**
 * Shared HTML email headers for WP Mail SMTP / wp_mail().
 */
function alupro_dynamic_form_mail_headers($reply_to_email = '', $reply_to_name = '')
{
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$reply_to_email = sanitize_email($reply_to_email);

	if ($reply_to_email && is_email($reply_to_email)) {
		$reply_to_name = sanitize_text_field($reply_to_name);
		$headers[] = 'Reply-To: ' . ($reply_to_name ? $reply_to_name . ' <' . $reply_to_email . '>' : $reply_to_email);
	}

	return $headers;
}

/**
 * Branded HTML email template for frontend forms.
 */
function alupro_dynamic_form_email_template($heading, $intro, $rows = array(), $note = '')
{
	$brand_name = 'AluPro Alloy Solutions';
	$site_url = home_url('/');

	ob_start();
	?>
	<!doctype html>
	<html>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo esc_html($heading); ?></title>
	</head>
	<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
		<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="width:100%;background:#f4f7fb;margin:0;padding:32px 16px;">
			<tr>
				<td align="center">
					<table role="presentation" width="640" cellspacing="0" cellpadding="0" style="width:100%;max-width:640px;background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #dbe6f3;">
						<tr>
							<td style="background:#120A45;padding:30px 32px;">
								<p style="margin:0 0 12px;color:#00a2e0;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">
									<?php echo esc_html($brand_name); ?>
								</p>
								<h1 style="margin:0;color:#ffffff;font-size:28px;line-height:1.2;font-weight:800;">
									<?php echo esc_html($heading); ?>
								</h1>
							</td>
						</tr>
						<tr>
							<td style="padding:30px 32px;">
								<p style="margin:0 0 24px;color:#4B5563;font-size:16px;line-height:1.7;">
									<?php echo esc_html($intro); ?>
								</p>

								<?php if (!empty($rows)) : ?>
									<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;border:1px solid #e5edf6;border-radius:12px;overflow:hidden;">
										<?php foreach ($rows as $label => $value) : ?>
											<tr>
												<td style="width:34%;padding:14px 16px;background:#F8FAFC;border-bottom:1px solid #e5edf6;color:#190E5D;font-size:13px;font-weight:700;vertical-align:top;">
													<?php echo esc_html($label); ?>
												</td>
												<td style="padding:14px 16px;border-bottom:1px solid #e5edf6;color:#374151;font-size:14px;line-height:1.6;vertical-align:top;">
													<?php echo nl2br(esc_html($value)); ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</table>
								<?php endif; ?>

								<?php if ($note) : ?>
									<p style="margin:24px 0 0;color:#4B5563;font-size:14px;line-height:1.7;">
										<?php echo esc_html($note); ?>
									</p>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td style="padding:20px 32px;background:#F8FAFC;border-top:1px solid #e5edf6;">
								<p style="margin:0;color:#6B7280;font-size:12px;line-height:1.6;">
									<?php esc_html_e('This email was sent from', 'alupro-dynamic'); ?>
									<a href="<?php echo esc_url($site_url); ?>" style="color:#00a2e0;text-decoration:none;"><?php echo esc_html(wp_parse_url($site_url, PHP_URL_HOST)); ?></a>.
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
	</html>
	<?php

	return trim(ob_get_clean());
}

/**
 * Handle newsletter subscriptions through wp_mail().
 */
function alupro_dynamic_handle_newsletter_subscribe()
{
	if (empty($_POST['alupro_newsletter_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alupro_newsletter_nonce'])), 'alupro_newsletter_subscribe')) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_subscribe', 'error'));
		exit;
	}

	$honeypot = isset($_POST['website']) ? trim((string) wp_unslash($_POST['website'])) : '';
	if ('' !== $honeypot) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_subscribe', 'success'));
		exit;
	}

	$email = isset($_POST['subscriber_email']) ? sanitize_email(wp_unslash($_POST['subscriber_email'])) : '';
	if (!$email || !is_email($email)) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_subscribe', 'invalid'));
		exit;
	}

	$admin_email = alupro_dynamic_form_recipient_email();
	$submitted_at = wp_date(get_option('date_format') . ' ' . get_option('time_format'));
	$admin_subject = sprintf(__('New newsletter subscription - %s', 'alupro-dynamic'), wp_parse_url(home_url(), PHP_URL_HOST));
	$admin_message = alupro_dynamic_form_email_template(
		__('New newsletter subscription', 'alupro-dynamic'),
		__('A visitor subscribed to receive AluPro updates.', 'alupro-dynamic'),
		array(
			__('Subscriber Email', 'alupro-dynamic') => $email,
			__('Source', 'alupro-dynamic') => home_url('/'),
			__('Submitted At', 'alupro-dynamic') => $submitted_at,
		)
	);
	$client_subject = __('You are subscribed to AluPro updates', 'alupro-dynamic');
	$client_message = alupro_dynamic_form_email_template(
		__('Subscription received', 'alupro-dynamic'),
		__('Thank you for subscribing to AluPro Alloy Solutions. We will send relevant aluminium product updates and announcements to this email address.', 'alupro-dynamic'),
		array(
			__('Subscribed Email', 'alupro-dynamic') => $email,
		),
		__('If you did not request this subscription, you can ignore this email.', 'alupro-dynamic')
	);

	$admin_sent = wp_mail($admin_email, $admin_subject, $admin_message, alupro_dynamic_form_mail_headers($email));
	$client_sent = wp_mail($email, $client_subject, $client_message, alupro_dynamic_form_mail_headers($admin_email, get_bloginfo('name')));

	wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_subscribe', ($admin_sent && $client_sent) ? 'success' : 'error'));
	exit;
}
add_action('admin_post_nopriv_alupro_newsletter_subscribe', 'alupro_dynamic_handle_newsletter_subscribe');
add_action('admin_post_alupro_newsletter_subscribe', 'alupro_dynamic_handle_newsletter_subscribe');

/**
 * Handle quote/enquiry submissions through wp_mail().
 */
function alupro_dynamic_handle_quote_enquiry()
{
	if (empty($_POST['alupro_quote_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alupro_quote_nonce'])), 'alupro_quote_enquiry')) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_enquiry', 'error'));
		exit;
	}

	$honeypot = isset($_POST['website']) ? trim((string) wp_unslash($_POST['website'])) : '';
	if ('' !== $honeypot) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_enquiry', 'success'));
		exit;
	}

	$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
	$company = isset($_POST['company']) ? sanitize_text_field(wp_unslash($_POST['company'])) : '';
	$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
	$phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
	$details = isset($_POST['details']) ? sanitize_textarea_field(wp_unslash($_POST['details'])) : '';

	if ('' === $name || !$email || !is_email($email) || '' === $details) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_enquiry', 'invalid'));
		exit;
	}

	$admin_email = alupro_dynamic_form_recipient_email();
	$submitted_at = wp_date(get_option('date_format') . ' ' . get_option('time_format'));
	$enquiry_rows = array(
		__('Name', 'alupro-dynamic') => $name,
		__('Company / Shipyard', 'alupro-dynamic') => $company ? $company : '-',
		__('Email', 'alupro-dynamic') => $email,
		__('Phone', 'alupro-dynamic') => $phone ? $phone : '-',
		__('Project Details', 'alupro-dynamic') => $details,
		__('Source', 'alupro-dynamic') => home_url('/'),
		__('Submitted At', 'alupro-dynamic') => $submitted_at,
	);
	$admin_subject = sprintf(__('New aluminium enquiry - %s', 'alupro-dynamic'), $name);
	$admin_message = alupro_dynamic_form_email_template(
		__('New aluminium enquiry', 'alupro-dynamic'),
		__('A visitor submitted a quote request from the AluPro website.', 'alupro-dynamic'),
		$enquiry_rows
	);
	$client_subject = __('We received your AluPro enquiry', 'alupro-dynamic');
	$client_message = alupro_dynamic_form_email_template(
		__('Your enquiry has been received', 'alupro-dynamic'),
		__('Thank you for contacting AluPro Alloy Solutions. Our team has received your request and will review the details during business hours.', 'alupro-dynamic'),
		array(
			__('Name', 'alupro-dynamic') => $name,
			__('Company / Shipyard', 'alupro-dynamic') => $company ? $company : '-',
			__('Email', 'alupro-dynamic') => $email,
			__('Phone', 'alupro-dynamic') => $phone ? $phone : '-',
			__('Project Details', 'alupro-dynamic') => $details,
		),
		__('We will reply to you as soon as possible. For urgent requirements, please contact us by phone.', 'alupro-dynamic')
	);

	$admin_sent = wp_mail($admin_email, $admin_subject, $admin_message, alupro_dynamic_form_mail_headers($email, $name));
	$client_sent = wp_mail($email, $client_subject, $client_message, alupro_dynamic_form_mail_headers($admin_email, get_bloginfo('name')));

	wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_enquiry', ($admin_sent && $client_sent) ? 'success' : 'error'));
	exit;
}
add_action('admin_post_nopriv_alupro_quote_enquiry', 'alupro_dynamic_handle_quote_enquiry');
add_action('admin_post_alupro_quote_enquiry', 'alupro_dynamic_handle_quote_enquiry');

/**
 * Handle Contact page submissions through wp_mail().
 */
function alupro_dynamic_handle_contact_enquiry()
{
	if (empty($_POST['alupro_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alupro_contact_nonce'])), 'alupro_contact_enquiry')) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_contact', 'error'));
		exit;
	}

	$honeypot = isset($_POST['website']) ? trim((string) wp_unslash($_POST['website'])) : '';
	if ('' !== $honeypot) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_contact', 'success'));
		exit;
	}

	$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
	$company = isset($_POST['company']) ? sanitize_text_field(wp_unslash($_POST['company'])) : '';
	$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
	$phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
	$subject = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
	$message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

	if ('' === $name || !$email || !is_email($email) || '' === $message) {
		wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_contact', 'invalid'));
		exit;
	}

	if ('' === $subject) {
		$subject = __('Website contact enquiry', 'alupro-dynamic');
	}

	$admin_email = alupro_dynamic_form_recipient_email();
	$submitted_at = wp_date(get_option('date_format') . ' ' . get_option('time_format'));
	$contact_rows = array(
		__('Name', 'alupro-dynamic') => $name,
		__('Company', 'alupro-dynamic') => $company ? $company : '-',
		__('Email', 'alupro-dynamic') => $email,
		__('Phone', 'alupro-dynamic') => $phone ? $phone : '-',
		__('Subject', 'alupro-dynamic') => $subject,
		__('Message', 'alupro-dynamic') => $message,
		__('Source', 'alupro-dynamic') => home_url('/contact/'),
		__('Submitted At', 'alupro-dynamic') => $submitted_at,
	);
	$admin_subject = sprintf(__('New contact message - %s', 'alupro-dynamic'), $name);
	$admin_message = alupro_dynamic_form_email_template(
		__('New contact message', 'alupro-dynamic'),
		__('A visitor submitted the Contact Us form on the AluPro website.', 'alupro-dynamic'),
		$contact_rows
	);
	$client_subject = __('We received your message', 'alupro-dynamic');
	$client_message = alupro_dynamic_form_email_template(
		__('Your message has been received', 'alupro-dynamic'),
		__('Thank you for contacting AluPro Alloy Solutions. Our team has received your message and will review it during business hours.', 'alupro-dynamic'),
		array(
			__('Name', 'alupro-dynamic') => $name,
			__('Company', 'alupro-dynamic') => $company ? $company : '-',
			__('Email', 'alupro-dynamic') => $email,
			__('Phone', 'alupro-dynamic') => $phone ? $phone : '-',
			__('Subject', 'alupro-dynamic') => $subject,
			__('Message', 'alupro-dynamic') => $message,
		),
		__('We will reply as soon as possible. For urgent aluminium requirements, please call our office directly.', 'alupro-dynamic')
	);

	$admin_sent = wp_mail($admin_email, $admin_subject, $admin_message, alupro_dynamic_form_mail_headers($email, $name));
	$client_sent = wp_mail($email, $client_subject, $client_message, alupro_dynamic_form_mail_headers($admin_email, get_bloginfo('name')));

	wp_safe_redirect(alupro_dynamic_form_redirect_url('alupro_contact', ($admin_sent && $client_sent) ? 'success' : 'error'));
	exit;
}
add_action('admin_post_nopriv_alupro_contact_enquiry', 'alupro_dynamic_handle_contact_enquiry');
add_action('admin_post_alupro_contact_enquiry', 'alupro_dynamic_handle_contact_enquiry');

/**
 * Get the Custom Services page ID dynamically.
 */
function alupro_get_custom_services_page_id()
{
	if (is_page_template('page-custom-services.php')) {
		return get_the_ID();
	}

	$pages = get_posts(array(
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-custom-services.php',
		'posts_per_page' => 1,
	));

	if (!empty($pages)) {
		return $pages[0]->ID;
	}

	$page = get_page_by_path('custom-services');
	if ($page) {
		return $page->ID;
	}

	return null;
}

/**
 * Front page section registry used by rendering and admin ordering.
 */
function alupro_dynamic_home_section_definitions()
{
	return array(
		'banner' => array(
			'label' => __('Hero Banner', 'alupro-dynamic'),
			'description' => __('Top homepage banner with headline and quote buttons.', 'alupro-dynamic'),
		),
		'about' => array(
			'label' => __('About Section', 'alupro-dynamic'),
			'description' => __('Company overview, statistics, and highlight cards.', 'alupro-dynamic'),
		),
		'browse' => array(
			'label' => __('Browse by Industry', 'alupro-dynamic'),
			'description' => __('Industry cards linking visitors to product areas.', 'alupro-dynamic'),
		),
		'products' => array(
			'label' => __('Product Sections', 'alupro-dynamic'),
			'description' => __('Dynamic aluminium product sections from product categories.', 'alupro-dynamic'),
		),
		'custom_services' => array(
			'label' => __('Custom Services', 'alupro-dynamic'),
			'description' => __('Precision aluminium services section on the homepage.', 'alupro-dynamic'),
		),
		'newsletter' => array(
			'label' => __('Newsletter Signup', 'alupro-dynamic'),
			'description' => __('Static subscription call-to-action above the footer.', 'alupro-dynamic'),
		),
	);
}

/**
 * Redirect the old Custom Services page to the homepage section.
 */
function alupro_dynamic_redirect_custom_services_page()
{
	if (is_admin() || wp_doing_ajax()) {
		return;
	}

	if (is_page('custom-services') || is_page_template('page-custom-services.php')) {
		wp_safe_redirect(alupro_dynamic_custom_services_anchor_url(), 301);
		exit;
	}
}
add_action('template_redirect', 'alupro_dynamic_redirect_custom_services_page');

/**
 * Normalize front page section settings saved from the admin page.
 */
function alupro_dynamic_get_home_section_settings()
{
	$definitions = alupro_dynamic_home_section_definitions();
	$default_order = array_keys($definitions);
	$stored = get_option('alupro_dynamic_home_sections', array());

	$order = array();
	if (!empty($stored['order']) && is_array($stored['order'])) {
		foreach ($stored['order'] as $section_key) {
			$section_key = sanitize_key($section_key);
			if (isset($definitions[$section_key]) && !in_array($section_key, $order, true)) {
				$order[] = $section_key;
			}
		}
	}

	foreach ($default_order as $section_key) {
		if (!in_array($section_key, $order, true)) {
			$order[] = $section_key;
		}
	}

	$enabled = array();
	foreach ($default_order as $section_key) {
		$enabled[$section_key] = 1;
		if (isset($stored['enabled']) && is_array($stored['enabled']) && array_key_exists($section_key, $stored['enabled'])) {
			$enabled[$section_key] = !empty($stored['enabled'][$section_key]) ? 1 : 0;
		}
	}

	return array(
		'order' => $order,
		'enabled' => $enabled,
	);
}

/**
 * Render one registered front page section.
 */
function alupro_dynamic_render_home_section($section_key)
{
	switch ($section_key) {
		case 'banner':
			get_template_part('template-parts/banner');
			break;
		case 'about':
			get_template_part('template-parts/about');
			break;
		case 'browse':
			get_template_part('template-parts/browse');
			break;
		case 'products':
			get_template_part('template-parts/product-sections');
			break;
		case 'custom_services':
			get_template_part('template-parts/custom-services');
			break;
		case 'newsletter':
			get_template_part('template-parts/newsletter');
			break;
	}
}

/**
 * Render enabled front page sections in admin-managed order.
 */
function alupro_dynamic_render_home_sections()
{
	$settings = alupro_dynamic_get_home_section_settings();

	foreach ($settings['order'] as $section_key) {
		if (empty($settings['enabled'][$section_key])) {
			continue;
		}

		alupro_dynamic_render_home_section($section_key);
	}
}

/**
 * Register admin page for front page section visibility and order.
 */
function alupro_dynamic_register_home_sections_admin_page()
{
	add_theme_page(
		__('Homepage Sections', 'alupro-dynamic'),
		__('Homepage Sections', 'alupro-dynamic'),
		'edit_theme_options',
		'alupro-homepage-sections',
		'alupro_dynamic_home_sections_admin_page'
	);
}
add_action('admin_menu', 'alupro_dynamic_register_home_sections_admin_page');

/**
 * Load sortable behavior only on the homepage sections admin screen.
 */
function alupro_dynamic_home_sections_admin_assets($hook_suffix)
{
	if ('appearance_page_alupro-homepage-sections' !== $hook_suffix) {
		return;
	}

	wp_enqueue_script('jquery-ui-sortable');
	wp_add_inline_script(
		'jquery-ui-sortable',
		"jQuery(function($){var list=$('#alupro-home-section-list');var input=$('#alupro_home_section_order');function updateOrder(){var order=list.find('.alupro-home-section-item').map(function(){return $(this).data('section-key');}).get();input.val(order.join(','));}list.sortable({axis:'y',handle:'.alupro-home-section-handle',update:updateOrder});updateOrder();});"
	);
}
add_action('admin_enqueue_scripts', 'alupro_dynamic_home_sections_admin_assets');

/**
 * Save front page section visibility and order.
 */
function alupro_dynamic_save_home_sections()
{
	if (!current_user_can('edit_theme_options')) {
		wp_die(esc_html__('You do not have permission to edit homepage sections.', 'alupro-dynamic'));
	}

	check_admin_referer('alupro_save_home_sections');

	if (isset($_POST['alupro_home_sections_reset'])) {
		delete_option('alupro_dynamic_home_sections');
		wp_safe_redirect(add_query_arg('settings-updated', 'reset', admin_url('themes.php?page=alupro-homepage-sections')));
		exit;
	}

	$definitions = alupro_dynamic_home_section_definitions();
	$order_value = isset($_POST['alupro_home_section_order']) ? sanitize_text_field(wp_unslash($_POST['alupro_home_section_order'])) : '';
	$posted_order = array_filter(array_map('sanitize_key', explode(',', $order_value)));
	$order = array();

	foreach ($posted_order as $section_key) {
		if (isset($definitions[$section_key]) && !in_array($section_key, $order, true)) {
			$order[] = $section_key;
		}
	}

	foreach (array_keys($definitions) as $section_key) {
		if (!in_array($section_key, $order, true)) {
			$order[] = $section_key;
		}
	}

	$posted_enabled = isset($_POST['alupro_home_sections_enabled']) ? (array) wp_unslash($_POST['alupro_home_sections_enabled']) : array();
	$posted_enabled = array_map('sanitize_key', $posted_enabled);
	$enabled = array();

	foreach (array_keys($definitions) as $section_key) {
		$enabled[$section_key] = in_array($section_key, $posted_enabled, true) ? 1 : 0;
	}

	update_option(
		'alupro_dynamic_home_sections',
		array(
			'order' => $order,
			'enabled' => $enabled,
		)
	);

	wp_safe_redirect(add_query_arg('settings-updated', 'true', admin_url('themes.php?page=alupro-homepage-sections')));
	exit;
}
add_action('admin_post_alupro_save_home_sections', 'alupro_dynamic_save_home_sections');

/**
 * Admin page markup for front page section visibility and order.
 */
function alupro_dynamic_home_sections_admin_page()
{
	if (!current_user_can('edit_theme_options')) {
		return;
	}

	$definitions = alupro_dynamic_home_section_definitions();
	$settings = alupro_dynamic_get_home_section_settings();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('Homepage Sections', 'alupro-dynamic'); ?></h1>

		<?php if (isset($_GET['settings-updated']) && 'true' === $_GET['settings-updated']) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e('Homepage section settings saved.', 'alupro-dynamic'); ?></p></div>
		<?php elseif (isset($_GET['settings-updated']) && 'reset' === $_GET['settings-updated']) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e('Homepage sections reset to the default order.', 'alupro-dynamic'); ?></p></div>
		<?php endif; ?>

		<p><?php esc_html_e('Drag sections to reorder the front page. Uncheck a section to hide it from the front page.', 'alupro-dynamic'); ?></p>

		<style>
			.alupro-home-section-list {
				max-width: 820px;
			}

			.alupro-home-section-item {
				align-items: center;
				background: #fff;
				border: 1px solid #dcdcde;
				border-radius: 8px;
				display: grid;
				gap: 14px;
				grid-template-columns: 36px minmax(0, 1fr) auto;
				margin: 0 0 10px;
				padding: 14px;
			}

			.alupro-home-section-handle {
				color: #646970;
				cursor: move;
				font-size: 20px;
				text-align: center;
			}

			.alupro-home-section-title {
				display: block;
				font-weight: 600;
				margin-bottom: 4px;
			}

			.alupro-home-section-description {
				color: #646970;
				margin: 0;
			}
		</style>

		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<?php wp_nonce_field('alupro_save_home_sections'); ?>
			<input type="hidden" name="action" value="alupro_save_home_sections">
			<input type="hidden" id="alupro_home_section_order" name="alupro_home_section_order" value="<?php echo esc_attr(implode(',', $settings['order'])); ?>">

			<ul id="alupro-home-section-list" class="alupro-home-section-list">
				<?php foreach ($settings['order'] as $section_key) : ?>
					<?php if (!isset($definitions[$section_key])) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<li class="alupro-home-section-item" data-section-key="<?php echo esc_attr($section_key); ?>">
						<span class="dashicons dashicons-menu alupro-home-section-handle" aria-hidden="true"></span>
						<div>
							<span class="alupro-home-section-title"><?php echo esc_html($definitions[$section_key]['label']); ?></span>
							<p class="alupro-home-section-description"><?php echo esc_html($definitions[$section_key]['description']); ?></p>
						</div>
						<label>
							<input
								type="checkbox"
								name="alupro_home_sections_enabled[]"
								value="<?php echo esc_attr($section_key); ?>"
								<?php checked(!empty($settings['enabled'][$section_key])); ?>
							>
							<?php esc_html_e('Show', 'alupro-dynamic'); ?>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php submit_button(__('Save Homepage Sections', 'alupro-dynamic'), 'primary', 'submit', false); ?>
			<?php submit_button(__('Reset to Default', 'alupro-dynamic'), 'secondary', 'alupro_home_sections_reset', false); ?>
		</form>
	</div>
	<?php
}

/**
 * Register admin page for footer text, contact, and social settings.
 */
function alupro_dynamic_register_footer_settings_admin_page()
{
	add_theme_page(
		__('Footer Settings', 'alupro-dynamic'),
		__('Footer Settings', 'alupro-dynamic'),
		'edit_theme_options',
		'alupro-footer-settings',
		'alupro_dynamic_footer_settings_admin_page'
	);
}
add_action('admin_menu', 'alupro_dynamic_register_footer_settings_admin_page');

/**
 * Save dynamic footer settings.
 */
function alupro_dynamic_save_footer_settings()
{
	if (!current_user_can('edit_theme_options')) {
		wp_die(esc_html__('You do not have permission to edit footer settings.', 'alupro-dynamic'));
	}

	check_admin_referer('alupro_save_footer_settings');

	if (isset($_POST['alupro_footer_settings_reset'])) {
		delete_option('alupro_dynamic_footer_settings');
		wp_safe_redirect(add_query_arg('settings-updated', 'reset', admin_url('themes.php?page=alupro-footer-settings')));
		exit;
	}

	$text_fields = array(
		'description',
		'mailing_address',
		'warehouse_address',
		'footer_1_title',
		'footer_2_title',
		'footer_3_title',
		'contact_title',
		'phone',
		'fax',
		'hours',
		'copyright',
	);

	$url_fields = array(
		'linkedin_url',
		'facebook_url',
		'x_url',
	);

	$settings = array();

	foreach ($text_fields as $field) {
		$value = isset($_POST['alupro_footer_settings'][$field]) ? wp_unslash($_POST['alupro_footer_settings'][$field]) : '';
		$settings[$field] = in_array($field, array('description', 'mailing_address', 'warehouse_address'), true)
			? sanitize_textarea_field($value)
			: sanitize_text_field($value);
	}

	$email = isset($_POST['alupro_footer_settings']['email']) ? wp_unslash($_POST['alupro_footer_settings']['email']) : '';
	$settings['email'] = sanitize_email($email);

	foreach ($url_fields as $field) {
		$value = isset($_POST['alupro_footer_settings'][$field]) ? wp_unslash($_POST['alupro_footer_settings'][$field]) : '';
		$settings[$field] = esc_url_raw($value);
	}

	update_option('alupro_dynamic_footer_settings', $settings);

	wp_safe_redirect(add_query_arg('settings-updated', 'true', admin_url('themes.php?page=alupro-footer-settings')));
	exit;
}
add_action('admin_post_alupro_save_footer_settings', 'alupro_dynamic_save_footer_settings');

/**
 * Footer settings admin page markup.
 */
function alupro_dynamic_footer_settings_admin_page()
{
	if (!current_user_can('edit_theme_options')) {
		return;
	}

	$settings = alupro_dynamic_get_footer_settings();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('Footer Settings', 'alupro-dynamic'); ?></h1>

		<?php if (isset($_GET['settings-updated']) && 'true' === $_GET['settings-updated']) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e('Footer settings saved.', 'alupro-dynamic'); ?></p></div>
		<?php elseif (isset($_GET['settings-updated']) && 'reset' === $_GET['settings-updated']) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e('Footer settings reset to defaults.', 'alupro-dynamic'); ?></p></div>
		<?php endif; ?>

		<p>
			<?php esc_html_e('Use Appearance > Menus to assign links to Footer 1 Menu, Footer 2 Menu, Footer 3 Menu, and Footer Legal Menu. Use this screen for footer text and contact details.', 'alupro-dynamic'); ?>
		</p>

		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<?php wp_nonce_field('alupro_save_footer_settings'); ?>
			<input type="hidden" name="action" value="alupro_save_footer_settings">

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="alupro_footer_description"><?php esc_html_e('Footer Description', 'alupro-dynamic'); ?></label></th>
					<td>
						<textarea id="alupro_footer_description" name="alupro_footer_settings[description]" rows="4" class="large-text"><?php echo esc_textarea($settings['description']); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="alupro_footer_mailing_address"><?php esc_html_e('Mailing Address', 'alupro-dynamic'); ?></label></th>
					<td>
						<textarea id="alupro_footer_mailing_address" name="alupro_footer_settings[mailing_address]" rows="3" class="large-text"><?php echo esc_textarea($settings['mailing_address']); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="alupro_footer_warehouse_address"><?php esc_html_e('Warehouse Address', 'alupro-dynamic'); ?></label></th>
					<td>
						<textarea id="alupro_footer_warehouse_address" name="alupro_footer_settings[warehouse_address]" rows="3" class="large-text"><?php echo esc_textarea($settings['warehouse_address']); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Menu Column Titles', 'alupro-dynamic'); ?></th>
					<td>
						<input type="text" name="alupro_footer_settings[footer_1_title]" value="<?php echo esc_attr($settings['footer_1_title']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Footer 1 title', 'alupro-dynamic'); ?>">
						<input type="text" name="alupro_footer_settings[footer_2_title]" value="<?php echo esc_attr($settings['footer_2_title']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Footer 2 title', 'alupro-dynamic'); ?>">
						<input type="text" name="alupro_footer_settings[footer_3_title]" value="<?php echo esc_attr($settings['footer_3_title']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Footer 3 title', 'alupro-dynamic'); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="alupro_footer_contact_title"><?php esc_html_e('Contact Column Title', 'alupro-dynamic'); ?></label></th>
					<td>
						<input id="alupro_footer_contact_title" type="text" name="alupro_footer_settings[contact_title]" value="<?php echo esc_attr($settings['contact_title']); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Contact Details', 'alupro-dynamic'); ?></th>
					<td>
						<p><input type="text" name="alupro_footer_settings[phone]" value="<?php echo esc_attr($settings['phone']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Phone', 'alupro-dynamic'); ?>"></p>
						<p><input type="email" name="alupro_footer_settings[email]" value="<?php echo esc_attr($settings['email']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Email', 'alupro-dynamic'); ?>"></p>
						<p><input type="text" name="alupro_footer_settings[fax]" value="<?php echo esc_attr($settings['fax']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Fax', 'alupro-dynamic'); ?>"></p>
						<p><input type="text" name="alupro_footer_settings[hours]" value="<?php echo esc_attr($settings['hours']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Business hours', 'alupro-dynamic'); ?>"></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Social Links', 'alupro-dynamic'); ?></th>
					<td>
						<p><input type="url" name="alupro_footer_settings[linkedin_url]" value="<?php echo esc_attr($settings['linkedin_url']); ?>" class="regular-text" placeholder="<?php esc_attr_e('LinkedIn URL', 'alupro-dynamic'); ?>"></p>
						<p><input type="url" name="alupro_footer_settings[facebook_url]" value="<?php echo esc_attr($settings['facebook_url']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Facebook URL', 'alupro-dynamic'); ?>"></p>
						<p><input type="url" name="alupro_footer_settings[x_url]" value="<?php echo esc_attr($settings['x_url']); ?>" class="regular-text" placeholder="<?php esc_attr_e('X / Twitter URL', 'alupro-dynamic'); ?>"></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="alupro_footer_copyright"><?php esc_html_e('Copyright Text', 'alupro-dynamic'); ?></label></th>
					<td>
						<input id="alupro_footer_copyright" type="text" name="alupro_footer_settings[copyright]" value="<?php echo esc_attr($settings['copyright']); ?>" class="large-text">
					</td>
				</tr>
			</table>

			<?php submit_button(__('Save Footer Settings', 'alupro-dynamic'), 'primary', 'submit', false); ?>
			<?php submit_button(__('Reset to Default', 'alupro-dynamic'), 'secondary', 'alupro_footer_settings_reset', false); ?>
		</form>
	</div>
	<?php
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
