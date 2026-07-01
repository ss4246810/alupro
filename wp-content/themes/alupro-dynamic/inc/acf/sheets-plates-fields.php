<?php
/**
 * ACF Fields: Homepage Sheets & Plates Settings.
 *
 * @package AluProDynamic
 */

if (!function_exists('acf_add_local_field_group')) {
	return;
}

$fields = array(
	array(
		'key' => 'field_sheets_badge_text',
		'label' => __('Badge Text', 'alupro-dynamic'),
		'name' => 'sheets_badge_text',
		'type' => 'text',
		'default_value' => 'Product Range',
	),
	array(
		'key' => 'field_sheets_badge_icon',
		'label' => __('Badge Icon Class', 'alupro-dynamic'),
		'name' => 'sheets_badge_icon',
		'type' => 'text',
		'default_value' => 'fa-solid fa-layer-group',
	),
	array(
		'key' => 'field_sheets_title',
		'label' => __('Section Title', 'alupro-dynamic'),
		'name' => 'sheets_title',
		'type' => 'text',
		'default_value' => 'Sheets & Plates Aluminium',
	),
	array(
		'key' => 'field_sheets_description',
		'label' => __('Section Description', 'alupro-dynamic'),
		'name' => 'sheets_description',
		'type' => 'textarea',
		'default_value' => 'We supply premium-quality aluminium sheets and plates engineered for marine, aerospace, and industrial applications. Manufactured to the highest international standards, these materials offer excellent strength-to-weight ratio, superior corrosion resistance, and long-term durability.',
	),
	// Key Features
	array(
		'key' => 'field_sheets_features_title',
		'label' => __('Features Box Title', 'alupro-dynamic'),
		'name' => 'sheets_features_title',
		'type' => 'text',
		'default_value' => 'Key Features',
		'wrapper' => array('width' => '50%'),
	),
	array(
		'key' => 'field_sheets_features_icon',
		'label' => __('Features Box Icon', 'alupro-dynamic'),
		'name' => 'sheets_features_icon',
		'type' => 'text',
		'default_value' => 'fa-solid fa-star',
		'wrapper' => array('width' => '50%'),
	),
	array(
		'key' => 'field_sheets_features_list',
		'label' => __('Features List (One per line)', 'alupro-dynamic'),
		'name' => 'sheets_features_list',
		'type' => 'textarea',
		'default_value' => "Wide range of marine, aerospace, and industrial alloys\nAvailable in various thicknesses and tempers\nFull material certification and complete traceability\nReal-time stock visibility",
	),
	// Ideal For
	array(
		'key' => 'field_sheets_ideal_title',
		'label' => __('Ideal For Box Title', 'alupro-dynamic'),
		'name' => 'sheets_ideal_title',
		'type' => 'text',
		'default_value' => 'Ideal For',
		'wrapper' => array('width' => '50%'),
	),
	array(
		'key' => 'field_sheets_ideal_icon',
		'label' => __('Ideal For Box Icon', 'alupro-dynamic'),
		'name' => 'sheets_ideal_icon',
		'type' => 'text',
		'default_value' => 'fa-solid fa-bullseye',
		'wrapper' => array('width' => '50%'),
	),
	array(
		'key' => 'field_sheets_ideal_list',
		'label' => __('Ideal For List (One per line)', 'alupro-dynamic'),
		'name' => 'sheets_ideal_list',
		'type' => 'textarea',
		'default_value' => "Shipbuilding and offshore structures\nAircraft components\nPrecision industrial fabrications",
	),
	// Carousel Header
	array(
		'key' => 'field_sheets_carousel_icon',
		'label' => __('Carousel Header Icon', 'alupro-dynamic'),
		'name' => 'sheets_carousel_icon',
		'type' => 'text',
		'default_value' => 'fa-solid fa-anchor',
		'wrapper' => array('width' => '33%'),
	),
	array(
		'key' => 'field_sheets_carousel_sub',
		'label' => __('Carousel Header Subtitle', 'alupro-dynamic'),
		'name' => 'sheets_carousel_sub',
		'type' => 'text',
		'default_value' => 'Marine Grade',
		'wrapper' => array('width' => '33%'),
	),
	array(
		'key' => 'field_sheets_carousel_title',
		'label' => __('Carousel Header Title', 'alupro-dynamic'),
		'name' => 'sheets_carousel_title',
		'type' => 'text',
		'default_value' => 'Marine Grade Aluminium',
		'wrapper' => array('width' => '34%'),
	),
);

// Append the 6 slides dynamically to make config dry & clean
for ($i = 1; $i <= 6; $i++) {
	$status_default = $i <= 3 ? 'In Stock' : 'Indent';
	$title_default = '';
	$desc_default = '';
	if ($i === 1) {
		$title_default = '5083 H116 / H321 Marine Aluminium';
		$desc_default = 'Outstanding seawater resistance for hull plates, decks, and welded marine structures.';
	} elseif ($i === 2) {
		$title_default = '5052 H32 Marine Aluminium';
		$desc_default = 'Strong corrosion resistance and weldability for decking, tanks, panels, and fittings.';
	} elseif ($i === 3) {
		$title_default = 'Aluminium Chequered Plate';
		$desc_default = 'Non-slip chequered plates for marine decking, walkways, ramps, and industrial flooring.';
	} elseif ($i === 4) {
		$title_default = '5383 H116 / H321 Marine Aluminium';
		$desc_default = 'High strength alloy with excellent corrosion resistance for shipbuilding and offshore structures.';
	} elseif ($i === 5) {
		$title_default = '5086 H116 Marine Aluminium';
		$desc_default = 'Excellent marine corrosion resistance for shipbuilding, offshore, and structural use.';
	} elseif ($i === 6) {
		$title_default = '5754 / 5454 Marine Aluminium';
		$desc_default = 'Superior formability and corrosion resistance for hulls, platforms, and fabricated components.';
	}

	$fields[] = array(
		'key' => "field_sheets_slide_{$i}_tab",
		'label' => sprintf(__('Slide %d', 'alupro-dynamic'), $i),
		'type' => 'tab',
		'placement' => 'top',
		'endpoint' => 0,
	);

	$fields[] = array(
		'key' => "field_sheets_slide_{$i}_image",
		'label' => sprintf(__('Slide %d Image', 'alupro-dynamic'), $i),
		'name' => "sheets_slide_{$i}_image",
		'type' => 'image',
		'return_format' => 'url',
		'wrapper' => array('width' => '50%'),
	);

	$fields[] = array(
		'key' => "field_sheets_slide_{$i}_status",
		'label' => sprintf(__('Slide %d Status', 'alupro-dynamic'), $i),
		'name' => "sheets_slide_{$i}_status",
		'type' => 'text',
		'default_value' => $status_default,
		'wrapper' => array('width' => '50%'),
	);

	$fields[] = array(
		'key' => "field_sheets_slide_{$i}_title",
		'label' => sprintf(__('Slide %d Title', 'alupro-dynamic'), $i),
		'name' => "sheets_slide_{$i}_title",
		'type' => 'text',
		'default_value' => $title_default,
		'wrapper' => array('width' => '50%'),
	);

	$fields[] = array(
		'key' => "field_sheets_slide_{$i}_link",
		'label' => sprintf(__('Slide %d Link', 'alupro-dynamic'), $i),
		'name' => "sheets_slide_{$i}_link",
		'type' => 'text',
		'default_value' => 'table-pdf.html',
		'wrapper' => array('width' => '50%'),
	);

	$fields[] = array(
		'key' => "field_sheets_slide_{$i}_desc",
		'label' => sprintf(__('Slide %d Description', 'alupro-dynamic'), $i),
		'name' => "sheets_slide_{$i}_desc",
		'type' => 'textarea',
		'default_value' => $desc_default,
	);
}

acf_add_local_field_group(array(
	'key' => 'group_homepage_sheets_plates',
	'title' => __('Homepage Sheets & Plates Settings', 'alupro-dynamic'),
	'fields' => $fields,
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
));
