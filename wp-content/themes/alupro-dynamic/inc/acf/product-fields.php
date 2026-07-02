<?php
/**
 * ACF Fields: Product Category & Aluminium Product Settings.
 *
 * @package AluProDynamic
 */

if (!function_exists('acf_add_local_field_group')) {
	return;
}

// 1. Field Group for Product Category Taxonomy Terms
acf_add_local_field_group(array(
	'key' => 'group_product_category_settings',
	'title' => __('Product Category Settings', 'alupro-dynamic'),
	'fields' => array(
		array(
			'key' => 'field_cat_badge_text',
			'label' => __('Badge Text', 'alupro-dynamic'),
			'name' => 'cat_badge_text',
			'type' => 'text',
			'instructions' => __('e.g. Product Range, Structural Range, etc.', 'alupro-dynamic'),
		),
		array(
			'key' => 'field_cat_badge_icon',
			'label' => __('Badge Icon Class', 'alupro-dynamic'),
			'name' => 'cat_badge_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-layer-group',
		),
		array(
			'key' => 'field_cat_section_title',
			'label' => __('Section Title', 'alupro-dynamic'),
			'name' => 'cat_section_title',
			'type' => 'text',
			'instructions' => __('e.g. Sheets & Plates Aluminium', 'alupro-dynamic'),
		),
		array(
			'key' => 'field_cat_section_description',
			'label' => __('Section Description', 'alupro-dynamic'),
			'name' => 'cat_section_description',
			'type' => 'textarea',
		),
		// Key Features Box
		array(
			'key' => 'field_cat_features_title',
			'label' => __('Features Box Title', 'alupro-dynamic'),
			'name' => 'cat_features_title',
			'type' => 'text',
			'default_value' => 'Key Features',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_cat_features_icon',
			'label' => __('Features Box Icon Class', 'alupro-dynamic'),
			'name' => 'cat_features_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-star',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_cat_features_list',
			'label' => __('Features List (One item per line)', 'alupro-dynamic'),
			'name' => 'cat_features_list',
			'type' => 'textarea',
		),
		// Ideal For Box
		array(
			'key' => 'field_cat_ideal_title',
			'label' => __('Ideal For Box Title', 'alupro-dynamic'),
			'name' => 'cat_ideal_title',
			'type' => 'text',
			'default_value' => 'Ideal For',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_cat_ideal_icon',
			'label' => __('Ideal For Box Icon Class', 'alupro-dynamic'),
			'name' => 'cat_ideal_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-bullseye',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_cat_ideal_list',
			'label' => __('Ideal For List (One item per line)', 'alupro-dynamic'),
			'name' => 'cat_ideal_list',
			'type' => 'textarea',
		),
		// Carousel Header
		array(
			'key' => 'field_cat_carousel_icon',
			'label' => __('Carousel Icon Class', 'alupro-dynamic'),
			'name' => 'cat_carousel_icon',
			'type' => 'text',
			'default_value' => 'fa-solid fa-anchor',
			'wrapper' => array('width' => '33%'),
		),
		array(
			'key' => 'field_cat_carousel_subtitle',
			'label' => __('Carousel Subtitle', 'alupro-dynamic'),
			'name' => 'cat_carousel_subtitle',
			'type' => 'text',
			'wrapper' => array('width' => '33%'),
		),
		array(
			'key' => 'field_cat_carousel_title',
			'label' => __('Carousel Title', 'alupro-dynamic'),
			'name' => 'cat_carousel_title',
			'type' => 'text',
			'wrapper' => array('width' => '34%'),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_category',
			),
		),
	),
));

// 2. Field Group for Aluminium Product CPT Posts
acf_add_local_field_group(array(
	'key' => 'group_aluminium_product_settings',
	'title' => __('Aluminium Product Settings', 'alupro-dynamic'),
	'fields' => array(
		array(
			'key' => 'field_prod_status',
			'label' => __('Product Status Badge', 'alupro-dynamic'),
			'name' => 'product_status',
			'type' => 'text',
			'default_value' => 'In Stock',
			'instructions' => __('e.g. In Stock, Indent, Out of Stock, etc.', 'alupro-dynamic'),
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_prod_short_desc',
			'label' => __('Short Description', 'alupro-dynamic'),
			'name' => 'product_short_desc',
			'type' => 'textarea',
			'instructions' => __('Used in the homepage slider cards.', 'alupro-dynamic'),
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_prod_image',
			'label' => __('Product Image', 'alupro-dynamic'),
			'name' => 'product_image',
			'type' => 'image',
			'return_format' => 'url',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_prod_pdf',
			'label' => __('Product PDF Catalog File', 'alupro-dynamic'),
			'name' => 'product_catalog_pdf',
			'type' => 'file',
			'return_format' => 'url',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_prod_tempers',
			'label' => __('Tempers', 'alupro-dynamic'),
			'name' => 'product_tempers',
			'type' => 'text',
			'default_value' => 'H116 | H321 | H111 | H112',
			'instructions' => __('Separate with vertical pipe bar. Shown on the details table page.', 'alupro-dynamic'),
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_prod_certifications',
			'label' => __('Certifications Info', 'alupro-dynamic'),
			'name' => 'product_certifications',
			'type' => 'textarea',
			'default_value' => 'Certified to: ASTM B928 (G66/G67 Tested) with ABS, BV, DNV and LR Cert.',
			'instructions' => __('Shown on the details table page.', 'alupro-dynamic'),
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_prod_table_headers',
			'label' => __('Table Column Headers (Comma separated)', 'alupro-dynamic'),
			'name' => 'product_table_headers',
			'type' => 'text',
			'default_value' => 'Thickness, Width, Length, Availability',
			'instructions' => __('e.g. Thickness, Width, Length, Availability. Change as needed for custom table structures.', 'alupro-dynamic'),
		),
		array(
			'key' => 'field_prod_table_data',
			'label' => __('Table Spreadsheet Data (Copy-Paste from Excel)', 'alupro-dynamic'),
			'name' => 'product_table_data',
			'type' => 'textarea',
			'instructions' => __('Copy a range of cells directly from Microsoft Excel (or a TSV/CSV format) and paste here. Leave first cell empty in rows to span thickness rowspan from cells above. Format: Thickness [tab] Width [tab] Length [tab] Availability.', 'alupro-dynamic'),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'aluminium_product',
			),
		),
	),
));
