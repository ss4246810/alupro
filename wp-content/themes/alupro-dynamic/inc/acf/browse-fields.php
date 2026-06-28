<?php
/**
 * ACF Fields: Homepage Browse Settings.
 *
 * @package AluProDynamic
 */

if (!function_exists('acf_add_local_field_group')) {
	return;
}

acf_add_local_field_group(array(
	'key' => 'group_homepage_browse',
	'title' => __('Homepage Browse Settings', 'alupro-dynamic'),
	'fields' => array(
		array(
			'key' => 'field_browse_title',
			'label' => __('Main Title', 'alupro-dynamic'),
			'name' => 'browse_title',
			'type' => 'text',
			'default_value' => 'Browse Aluminium by Industry',
		),
		array(
			'key' => 'field_browse_desc',
			'label' => __('Main Description', 'alupro-dynamic'),
			'name' => 'browse_desc',
			'type' => 'textarea',
			'default_value' => 'We provide high-performance aluminium solutions tailored to the specific demands of different sectors:',
		),
		// Card 1
		array(
			'key' => 'field_browse_card_1_icon',
			'label' => __('Card 1 Icon Class', 'alupro-dynamic'),
			'name' => 'browse_card_1_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-anchor',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_1_title',
			'label' => __('Card 1 Title', 'alupro-dynamic'),
			'name' => 'browse_card_1_title',
			'type' => 'text',
			'default_value' => 'Marine Shipbuilding',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_browse_card_1_link',
			'label' => __('Card 1 Link', 'alupro-dynamic'),
			'name' => 'browse_card_1_link',
			'type' => 'text',
			'default_value' => '#sheets-plates-aluminium',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_1_desc',
			'label' => __('Card 1 Description', 'alupro-dynamic'),
			'name' => 'browse_card_1_desc',
			'type' => 'textarea',
			'default_value' => 'Premium marine-grade aluminium plates, sheets, and extrusions for hull construction, decking, superstructures, and offshore platforms. Built for strength, corrosion resistance, and long-term performance at sea.',
		),
		// Card 2
		array(
			'key' => 'field_browse_card_2_icon',
			'label' => __('Card 2 Icon Class', 'alupro-dynamic'),
			'name' => 'browse_card_2_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-microchip',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_2_title',
			'label' => __('Card 2 Title', 'alupro-dynamic'),
			'name' => 'browse_card_2_title',
			'type' => 'text',
			'default_value' => 'Precision Semiconductor',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_browse_card_2_link',
			'label' => __('Card 2 Link', 'alupro-dynamic'),
			'name' => 'browse_card_2_link',
			'type' => 'text',
			'default_value' => '#',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_2_desc',
			'label' => __('Card 2 Description', 'alupro-dynamic'),
			'name' => 'browse_card_2_desc',
			'type' => 'textarea',
			'default_value' => 'Stable, high-precision aluminium grades ideal for equipment frames, chambers, platforms, and critical components where dimensional stability and cleanliness are essential.',
		),
		// Card 3
		array(
			'key' => 'field_browse_card_3_icon',
			'label' => __('Card 3 Icon Class', 'alupro-dynamic'),
			'name' => 'browse_card_3_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-industry',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_3_title',
			'label' => __('Card 3 Title', 'alupro-dynamic'),
			'name' => 'browse_card_3_title',
			'type' => 'text',
			'default_value' => 'General Engineering',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_browse_card_3_link',
			'label' => __('Card 3 Link', 'alupro-dynamic'),
			'name' => 'browse_card_3_link',
			'type' => 'text',
			'default_value' => '#',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_3_desc',
			'label' => __('Card 3 Description', 'alupro-dynamic'),
			'name' => 'browse_card_3_desc',
			'type' => 'textarea',
			'default_value' => 'Versatile structural aluminium profiles, bars, plates, and sheets for fabrication, machinery, frameworks, and industrial equipment.',
		),
		// Card 4
		array(
			'key' => 'field_browse_card_4_icon',
			'label' => __('Card 4 Icon Class', 'alupro-dynamic'),
			'name' => 'browse_card_4_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-plane',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_4_title',
			'label' => __('Card 4 Title', 'alupro-dynamic'),
			'name' => 'browse_card_4_title',
			'type' => 'text',
			'default_value' => 'Aerospace Manufacturing',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_browse_card_4_link',
			'label' => __('Card 4 Link', 'alupro-dynamic'),
			'name' => 'browse_card_4_link',
			'type' => 'text',
			'default_value' => '#',
			'wrapper' => array('width' => '25%'),
		),
		array(
			'key' => 'field_browse_card_4_desc',
			'label' => __('Card 4 Description', 'alupro-dynamic'),
			'name' => 'browse_card_4_desc',
			'type' => 'textarea',
			'default_value' => 'High-strength aerospace aluminium alloys engineered for critical structural components, offering superior strength-to-weight ratio and reliability.',
		),
	),
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
