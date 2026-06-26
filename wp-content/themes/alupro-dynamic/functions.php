<?php
/**
 * Theme setup and helpers.
 *
 * @package AluProDynamic
 */

if (! defined('ABSPATH')) {
	exit;
}

function alupro_dynamic_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __('Primary Navigation', 'alupro-dynamic'),
			'footer'  => __('Footer Navigation', 'alupro-dynamic'),
		)
	);
}
add_action('after_setup_theme', 'alupro_dynamic_setup');

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

function alupro_dynamic_enqueue_assets() {
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

function alupro_dynamic_customize_register($wp_customize) {
	$wp_customize->add_section(
		'alupro_home_banner',
		array(
			'title'    => __('Home Banner', 'alupro-dynamic'),
			'priority' => 30,
		)
	);

	$fields = array(
		'banner_eyebrow'      => array('ALUPRO ALLOY | MARINE ALUMINIUM', __('Eyebrow', 'alupro-dynamic'), 'text'),
		'banner_title'        => array('Built for the Sea', __('Title', 'alupro-dynamic'), 'text'),
		'banner_title_accent' => array('Engineered for Excellence', __('Title Accent', 'alupro-dynamic'), 'text'),
		'banner_description'  => array('Premium marine-grade aluminium alloys for shipbuilding and offshore structures. Full class society certification with immediate stock in Singapore.', __('Description', 'alupro-dynamic'), 'textarea'),
		'banner_primary_text' => array('Download Catalogue', __('Primary Button Text', 'alupro-dynamic'), 'text'),
		'banner_primary_url'  => array('#', __('Primary Button URL', 'alupro-dynamic'), 'url'),
		'banner_quote_text'   => array('Request a Quote', __('Quote Button Text', 'alupro-dynamic'), 'text'),
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
				'default'           => $field[0],
				'sanitize_callback' => $sanitize_callback,
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $field[1],
				'section' => 'alupro_home_banner',
				'type'    => $field[2],
			)
		);
	}

	$wp_customize->add_setting(
		'banner_image',
		array(
			'default'           => get_theme_file_uri('images/banner-img-1.webp'),
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'banner_image',
			array(
				'label'   => __('Banner Background', 'alupro-dynamic'),
				'section' => 'alupro_home_banner',
			)
		)
	);
}
add_action('customize_register', 'alupro_dynamic_customize_register');

function alupro_dynamic_asset_url($path) {
	return esc_url(get_theme_file_uri(ltrim($path, '/')));
}

function alupro_dynamic_get_logo_url() {
	$custom_logo_id = get_theme_mod('custom_logo');

	if ($custom_logo_id) {
		$logo = wp_get_attachment_image_url($custom_logo_id, 'full');

		if ($logo) {
			return $logo;
		}
	}

	return get_theme_file_uri('images/logo-white.svg');
}

class AluPro_Dynamic_Desktop_Menu_Walker extends Walker_Nav_Menu {
	public function start_lvl(&$output, $depth = 0, $args = null) {
		$output .= '<div class="dropdown absolute left-0 top-full w-66 bg-white rounded-xl shadow-xl pt-3 pb-2 border border-[#190E5D]/10 z-50">';
	}

	public function end_lvl(&$output, $depth = 0, $args = null) {
		$output .= '</div>';
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$has_children = in_array('menu-item-has-children', $item->classes, true);
		$url          = ! empty($item->url) ? $item->url : '#';
		$title        = apply_filters('the_title', $item->title, $item->ID);

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

	public function end_el(&$output, $item, $depth = 0, $args = null) {
		if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {
			$output .= '</div>';
		}
	}
}

class AluPro_Dynamic_Mobile_Menu_Walker extends Walker_Nav_Menu {
	public function start_lvl(&$output, $depth = 0, $args = null) {
		$output .= '<div class="mobile-dropdown hidden mt-4 ml-4">';
	}

	public function end_lvl(&$output, $depth = 0, $args = null) {
		$output .= '</div>';
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$has_children = in_array('menu-item-has-children', $item->classes, true);
		$url          = ! empty($item->url) ? $item->url : '#';
		$title        = apply_filters('the_title', $item->title, $item->ID);

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

	public function end_el(&$output, $item, $depth = 0, $args = null) {
		if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {
			$output .= '</div>';
		}
	}
}

function alupro_dynamic_static_desktop_menu() {
	?>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">Home</a>
	<a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">About Us</a>
	<div class="relative group desktop-dropdown-group">
		<button type="button" class="nav-link flex items-center gap-x-1.5 text-white/70 hover:text-[#00a2e0] py-4">
			Products
			<i class="fas fa-chevron-down text-xs text-white/70 transition-transform duration-300 group-hover:rotate-180 group-hover:text-[#00a2e0]"></i>
		</button>
		<div class="dropdown absolute left-0 top-full w-66 bg-white rounded-xl shadow-xl pt-3 pb-2 border border-[#190E5D]/10 z-50">
			<a href="#sheets-plates-aluminium" class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Marine Grade Aluminium</a>
			<a href="#structural-grade-aluminium" class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Structural Grade Aluminium</a>
			<a href="#aerospace-grade-aluminium" class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Aerospace Grade Aluminium</a>
			<a href="#extrusions-profiles-aluminium" class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Extrusions &amp; Profiles Aluminium </a>
			<a href="#specialty-range-aluminium" class="block px-6 py-3 text-[#111827] hover:bg-[#e6f6fc] hover:text-[#00a2e0]">Specialty Range Aluminium </a>
		</div>
	</div>
	<a href="#custom-services" class="nav-link text-white/70 hover:text-[#00a2e0]">Custom Services</a>
	<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="nav-link text-white/70 hover:text-[#00a2e0]">Contact</a>
	<?php
}

function alupro_dynamic_static_mobile_menu() {
	?>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="font-semibold text-[#111827]">Home</a>
	<a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="font-semibold text-[#111827]">About Us</a>
	<div>
		<button type="button" onclick="toggleMobileDropdown(this)" class="flex items-center justify-between w-full text-left font-semibold text-[#111827]">
			Products
			<i class="fas fa-chevron-down text-[#111827] transition-transform"></i>
		</button>
		<div class="mobile-dropdown hidden mt-4 ml-4">
			<a href="#sheets-plates-aluminium" class="block py-2 text-[#111827]">Marine Grade Aluminium</a>
			<a href="#structural-grade-aluminium" class="block py-2 text-[#111827]">Structural Grade Aluminium</a>
			<a href="#aerospace-grade-aluminium" class="block py-2 text-[#111827]">Aerospace Grade Aluminium</a>
			<a href="#extrusions-profiles-aluminium" class="block py-2 text-[#111827]">Extrusions &amp; Profiles Aluminium</a>
			<a href="#specialty-range-aluminium" class="block py-2 text-[#111827]">Specialty Range Aluminium</a>
		</div>
	</div>
	<a href="#custom-services" class="font-semibold text-[#111827]">Custom Services</a>
	<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="font-semibold text-[#111827]">Contact</a>
	<?php
}

function alupro_dynamic_static_fragment($start_marker, $end_marker = '') {
	$file = get_theme_file_path('templates/home-static.html');

	if (! file_exists($file)) {
		return '';
	}

	$html  = file_get_contents($file);
	$start = strpos($html, $start_marker);

	if (false === $start) {
		return '';
	}

	$start += strlen($start_marker);
	$end    = $end_marker ? strpos($html, $end_marker, $start) : false;

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

function alupro_dynamic_static_home_sections() {
	$file = get_theme_file_path('templates/home-static.html');

	if (! file_exists($file)) {
		return '';
	}

	$html      = file_get_contents($file);
	$about_end = strpos($html, '<!-- About Section Ends -->');
	$footer    = strpos($html, '<!-- Footer Starts -->');

	if (false === $about_end || false === $footer) {
		return '';
	}

	$about_end += strlen('<!-- About Section Ends -->');
	$fragment   = substr($html, $about_end, $footer - $about_end);
	$fragment = str_replace(
		array('src="images/', "src='images/", 'href="images/', "href='images/", 'url("images/', "url('images/"),
		array('src="' . esc_url(get_theme_file_uri('images/')), "src='" . esc_url(get_theme_file_uri('images/')), 'href="' . esc_url(get_theme_file_uri('images/')), "href='" . esc_url(get_theme_file_uri('images/')), 'url("' . esc_url(get_theme_file_uri('images/')), "url('" . esc_url(get_theme_file_uri('images/'))),
		$fragment
	);

	return $fragment;
}
