<?php
/**
 * ACF Fields: Contact Page Settings.
 *
 * @package AluProDynamic
 */

if (!function_exists('acf_add_local_field_group')) {
	return;
}

acf_add_local_field_group(array(
	'key' => 'group_contact_page',
	'title' => __('Contact Page Settings', 'alupro-dynamic'),
	'fields' => array(
		array(
			'key' => 'field_contact_eyebrow',
			'label' => __('Eyebrow Text', 'alupro-dynamic'),
			'name' => 'contact_eyebrow',
			'type' => 'text',
			'default_value' => 'Contact Us',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_contact_title',
			'label' => __('Page Title', 'alupro-dynamic'),
			'name' => 'contact_title',
			'type' => 'text',
			'default_value' => "Let's Get Connected",
		),
		array(
			'key' => 'field_contact_description',
			'label' => __('Page Description', 'alupro-dynamic'),
			'name' => 'contact_description',
			'type' => 'textarea',
			'default_value' => '',
		),
		array(
			'key' => 'field_contact_details_title',
			'label' => __('Details Section Title', 'alupro-dynamic'),
			'name' => 'contact_details_title',
			'type' => 'text',
			'default_value' => 'Direct Contact',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_contact_form_title',
			'label' => __('Form Title', 'alupro-dynamic'),
			'name' => 'contact_form_title',
			'type' => 'text',
			'default_value' => 'Send Your Message',
			'wrapper' => array('width' => '50%'),
		),
		array(
			'key' => 'field_contact_form_description',
			'label' => __('Form Description', 'alupro-dynamic'),
			'name' => 'contact_form_description',
			'type' => 'textarea',
			'default_value' => 'Fill the form below and we will contact you soon.',
		),
		array(
			'key' => 'field_contact_response_note',
			'label' => __('Response Note', 'alupro-dynamic'),
			'name' => 'contact_response_note',
			'type' => 'text',
			'default_value' => 'We reply within 2 hours during business hours.',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_template',
				'operator' => '==',
				'value' => 'page-contact.php',
			),
		),
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-contact.php',
			),
		),
	),
));
