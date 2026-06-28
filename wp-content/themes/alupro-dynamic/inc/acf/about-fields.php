<?php
/**
 * ACF Fields: About Us Page Settings.
 *
 * @package AluProDynamic
 */

if ( ! function_exists('acf_add_local_field_group') ) {
	return;
}

acf_add_local_field_group(array(
	'key' => 'group_about_page',
	'title' => __('About Us Page Settings', 'alupro-dynamic'),
	'fields' => array(
		array(
			'key' => 'field_about_eyebrow',
			'label' => __('Eyebrow Text', 'alupro-dynamic'),
			'name' => 'about_eyebrow',
			'type' => 'text',
			'default_value' => 'About Us',
		),
		array(
			'key' => 'field_about_title',
			'label' => __('Title', 'alupro-dynamic'),
			'name' => 'about_title',
			'type' => 'text',
			'default_value' => 'AluPro Alloy Solutions',
		),
		array(
			'key' => 'field_about_description_1',
			'label' => __('Description Paragraph 1', 'alupro-dynamic'),
			'name' => 'about_description_1',
			'type' => 'textarea',
			'default_value' => 'AluPro Alloy Solutions Pte Ltd is a Singapore-based stockholder and distributor of certified marine-grade Aluminium Alloys. With over 15 years of industry experience, we are guided by our motto, "Excellence in Aluminium Distribution", serving the marine, shipbuilding, offshore, and engineering sectors across Southeast Asia and beyond.',
		),
		array(
			'key' => 'field_about_description_2',
			'label' => __('Description Paragraph 2', 'alupro-dynamic'),
			'name' => 'about_description_2',
			'type' => 'textarea',
			'default_value' => 'Sourced from established global manufacturers, our alloys offer excellent strength-to-weight performance and corrosion resistance for shipbuilding, offshore structures, naval vessels, luxury yachts, and precision engineering.',
		),
		array(
			'key' => 'field_about_image',
			'label' => __('About Image', 'alupro-dynamic'),
			'name' => 'about_image',
			'type' => 'image',
			'return_format' => 'url',
		),
		array(
			'key' => 'field_about_badges',
			'label' => __('Certifications/Badges (comma-separated)', 'alupro-dynamic'),
			'name' => 'about_badges',
			'type' => 'text',
			'default_value' => 'ABS, Bureau Veritas, DNV, Lloyd\'s Register',
		),
		// Stats
		array(
			'key' => 'field_about_stat_1_val',
			'label' => __('Stat 1 Value', 'alupro-dynamic'),
			'name' => 'about_stat_1_val',
			'type' => 'text',
			'default_value' => '15+',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_1_lbl',
			'label' => __('Stat 1 Label', 'alupro-dynamic'),
			'name' => 'about_stat_1_lbl',
			'type' => 'text',
			'default_value' => 'Years Experience',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_2_val',
			'label' => __('Stat 2 Value', 'alupro-dynamic'),
			'name' => 'about_stat_2_val',
			'type' => 'text',
			'default_value' => '15+',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_2_lbl',
			'label' => __('Stat 2 Label', 'alupro-dynamic'),
			'name' => 'about_stat_2_lbl',
			'type' => 'text',
			'default_value' => 'Alloy Grades Supplies',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_3_val',
			'label' => __('Stat 3 Value', 'alupro-dynamic'),
			'name' => 'about_stat_3_val',
			'type' => 'text',
			'default_value' => '4+',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_3_lbl',
			'label' => __('Stat 3 Label', 'alupro-dynamic'),
			'name' => 'about_stat_3_lbl',
			'type' => 'text',
			'default_value' => 'Class Approvals',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_4_val',
			'label' => __('Stat 4 Value', 'alupro-dynamic'),
			'name' => 'about_stat_4_val',
			'type' => 'text',
			'default_value' => '100%',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_about_stat_4_lbl',
			'label' => __('Stat 4 Label', 'alupro-dynamic'),
			'name' => 'about_stat_4_lbl',
			'type' => 'text',
			'default_value' => 'Material Traceability',
			'wrapper' => array('width' => '50%'),
		),
		// Highlight Cards
		array(
			'key' => 'field_about_card_1_title',
			'label' => __('Highlight Card 1 Title', 'alupro-dynamic'),
			'name' => 'about_card_1_title',
			'type' => 'text',
			'default_value' => 'Marine & Shipbuilding Aluminium',
		),
		array(
			'key' => 'field_about_card_2_title',
			'label' => __('Highlight Card 2 Title', 'alupro-dynamic'),
			'name' => 'about_card_2_title',
			'type' => 'text',
			'default_value' => 'Precision Engineering & Aerospace Materials',
		),
		array(
			'key' => 'field_about_card_3_title',
			'label' => __('Highlight Card 3 Title', 'alupro-dynamic'),
			'name' => 'about_card_3_title',
			'type' => 'text',
			'default_value' => 'Certified Quality & Full Traceability',
		),
		// Capabilities and QA Cards
		array(
			'key' => 'field_about_cap_title',
			'label' => __('Capabilities Card Title', 'alupro-dynamic'),
			'name' => 'about_cap_title',
			'type' => 'text',
			'default_value' => 'Our Capabilities',
		),
		array(
			'key' => 'field_about_cap_desc',
			'label' => __('Capabilities Card Description', 'alupro-dynamic'),
			'name' => 'about_cap_desc',
			'type' => 'textarea',
			'default_value' => 'Sourced from established global manufacturers, our alloys offer excellent strength-to-weight performance and corrosion resistance for applications including shipbuilding, offshore structures, naval vessels, luxury yachts, and precision engineering.',
		),
		array(
			'key' => 'field_about_qa_title',
			'label' => __('Quality Assurance Card Title', 'alupro-dynamic'),
			'name' => 'about_qa_title',
			'type' => 'text',
			'default_value' => 'Quality Assurance',
		),
		array(
			'key' => 'field_about_qa_desc',
			'label' => __('Quality Assurance Card Description', 'alupro-dynamic'),
			'name' => 'about_qa_desc',
			'type' => 'textarea',
			'default_value' => 'AluPro maintains full material traceability and holds approvals from major classification societies, including ABS, Bureau Veritas (BV), DNV, and Lloyd\'s Register (LR), ensuring quality and compliance for the strongest requirements of marine and offshore projects.',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'page-about-us.php',
			),
		),
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-about-us.php',
			),
		),
	),
));
