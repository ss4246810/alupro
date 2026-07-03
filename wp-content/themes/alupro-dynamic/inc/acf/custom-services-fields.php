<?php
/**
 * ACF Fields: Custom Services Page Settings.
 *
 * @package AluProDynamic
 */

if (!function_exists('acf_add_local_field_group')) {
	return;
}

$card_defaults = array(
	1 => array(
		'icon' => 'fa-solid fa-link',
		'kicker' => 'Shipbuilding',
		'title' => 'Triplate transition joints',
	),
	2 => array(
		'icon' => 'fa-solid fa-fire-flame-curved',
		'kicker' => 'Welding',
		'title' => 'Welding wire 5183 / 5356',
	),
	3 => array(
		'icon' => 'fa-solid fa-chair',
		'kicker' => 'Marine Interior',
		'title' => 'Marine aluminium seating',
	),
	4 => array(
		'icon' => 'fa-solid fa-border-all',
		'kicker' => 'Panels',
		'title' => 'Perforated aluminium sheets & ceiling panels',
	),
);

$card_fields = array();
for ($i = 1; $i <= 4; $i++) {
	$card_fields[] = array(
		'key' => 'field_custom_services_card_' . $i . '_icon',
		'label' => sprintf(__('Service Card %d Icon Class', 'alupro-dynamic'), $i),
		'name' => 'custom_services_card_' . $i . '_icon',
		'type' => 'text',
		'default_value' => $card_defaults[$i]['icon'],
		'wrapper' => array('width' => '25%'),
	);
	$card_fields[] = array(
		'key' => 'field_custom_services_card_' . $i . '_kicker',
		'label' => sprintf(__('Service Card %d Category', 'alupro-dynamic'), $i),
		'name' => 'custom_services_card_' . $i . '_kicker',
		'type' => 'text',
		'default_value' => $card_defaults[$i]['kicker'],
		'wrapper' => array('width' => '25%'),
	);
	$card_fields[] = array(
		'key' => 'field_custom_services_card_' . $i . '_title',
		'label' => sprintf(__('Service Card %d Title', 'alupro-dynamic'), $i),
		'name' => 'custom_services_card_' . $i . '_title',
		'type' => 'text',
		'default_value' => $card_defaults[$i]['title'],
		'wrapper' => array('width' => '50%'),
	);
}

acf_add_local_field_group(array(
	'key' => 'group_custom_services_page',
	'title' => __('Custom Services Page Settings', 'alupro-dynamic'),
	'fields' => array_merge(
		array(
			array(
				'key' => 'field_custom_services_eyebrow',
				'label' => __('Eyebrow Text', 'alupro-dynamic'),
				'name' => 'custom_services_eyebrow',
				'type' => 'text',
				'default_value' => 'Precision Services',
				'wrapper' => array('width' => '50%'),
			),
			array(
				'key' => 'field_custom_services_eyebrow_icon',
				'label' => __('Eyebrow Icon Class', 'alupro-dynamic'),
				'name' => 'custom_services_eyebrow_icon',
				'type' => 'text',
				'default_value' => 'fa-solid fa-screwdriver-wrench',
				'wrapper' => array('width' => '50%'),
			),
			array(
				'key' => 'field_custom_services_title',
				'label' => __('Page Title', 'alupro-dynamic'),
				'name' => 'custom_services_title',
				'type' => 'text',
				'default_value' => 'Custom Services for Aluminium',
			),
			array(
				'key' => 'field_custom_services_description',
				'label' => __('Page Description', 'alupro-dynamic'),
				'name' => 'custom_services_description',
				'type' => 'textarea',
				'default_value' => 'We offer high-precision custom processing services for aluminium, tailored to meet the exacting requirements of marine shipbuilding, semiconductor equipment, and high-spec engineering projects. Our advanced fabrication capabilities ensure superior accuracy, efficiency, and quality finish for every component.',
			),
			array(
				'key' => 'field_custom_services_features_title',
				'label' => __('Features Box Title', 'alupro-dynamic'),
				'name' => 'custom_services_features_title',
				'type' => 'text',
				'default_value' => 'Key Features',
			),
			array(
				'key' => 'field_custom_services_features',
				'label' => __('Features List (One item per line)', 'alupro-dynamic'),
				'name' => 'custom_services_features',
				'type' => 'textarea',
				'default_value' => "Fiber laser cutting for clean, precise profiles\nCNC bending and forming\nProfessional TIG/MIG welding\nPlate rolling and curving\nSurface finishing and protective treatments\nFull traceability and quality documentation",
			),
			array(
				'key' => 'field_custom_services_ideal_title',
				'label' => __('Ideal For Box Title', 'alupro-dynamic'),
				'name' => 'custom_services_ideal_title',
				'type' => 'text',
				'default_value' => 'Ideal For',
			),
			array(
				'key' => 'field_custom_services_ideal',
				'label' => __('Ideal For List (One item per line)', 'alupro-dynamic'),
				'name' => 'custom_services_ideal',
				'type' => 'textarea',
				'default_value' => "Marine and offshore vessel construction\nSemiconductor manufacturing equipment\nPrecision industrial machinery\nArchitectural and structural aluminium projects\nCustom engineering fabrications",
			),
			array(
				'key' => 'field_custom_services_image',
				'label' => __('Feature Image', 'alupro-dynamic'),
				'name' => 'custom_services_image',
				'type' => 'image',
				'return_format' => 'url',
			),
			array(
				'key' => 'field_custom_services_image_status',
				'label' => __('Image Status Badge', 'alupro-dynamic'),
				'name' => 'custom_services_image_status',
				'type' => 'text',
				'default_value' => 'Available',
				'wrapper' => array('width' => '33%'),
			),
			array(
				'key' => 'field_custom_services_image_kicker',
				'label' => __('Image Kicker', 'alupro-dynamic'),
				'name' => 'custom_services_image_kicker',
				'type' => 'text',
				'default_value' => 'Precision Cutting & Fabrication',
				'wrapper' => array('width' => '33%'),
			),
			array(
				'key' => 'field_custom_services_image_title',
				'label' => __('Image Title', 'alupro-dynamic'),
				'name' => 'custom_services_image_title',
				'type' => 'text',
				'default_value' => 'Built to specification for vessels, equipment, and engineered assemblies.',
				'wrapper' => array('width' => '34%'),
			),
		),
		$card_fields,
		array()
	),
	'location' => array(
		array(
			array(
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'page-custom-services.php',
			),
		),
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-custom-services.php',
			),
		),
	),
));
