<?php
/**
 * Template Name: About Us
 *
 * @package AluProDynamic
 */

get_header();

// Helper to get ACF field with static fallback
$about_id = function_exists('alupro_get_about_page_id') ? alupro_get_about_page_id() : null;


if (!function_exists('alupro_get_about_field')) {
	function alupro_get_about_field($field_name, $default_value, $post_id = null) {
		if (function_exists('get_field')) {
			$val = get_field($field_name, $post_id);
			if (!empty($val)) {
				return $val;
			}
		}
		return $default_value;
	}
}
?>
<main class="flex flex-col flex-1 w-full overflow-hidden">
	<?php
	// Load the shared about section (2-column, stats, 3 cards)
	get_template_part('template-parts/about');
	?>
</main>
<?php
get_footer();
