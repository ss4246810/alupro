<?php
/**
 * One-time importer for static theme product categories and product cards.
 *
 * @package AluProDynamic
 */

if (!defined('ABSPATH')) {
	exit;
}

function alupro_dynamic_static_product_import_data()
{
	return array(
		'categories' => array(
			'marine-grade' => array(
				'name' => 'Marine Grade',
				'fields' => array(
					'cat_badge_text' => 'Product Range',
					'cat_badge_icon' => 'fa-solid fa-layer-group',
					'cat_section_title' => 'Sheets & Plates Aluminium',
					'cat_section_description' => 'We supply premium-quality aluminium sheets and plates engineered for marine, aerospace, and industrial applications. Manufactured to the highest international standards, these materials offer excellent strength-to-weight ratio, superior corrosion resistance, and long-term durability.',
					'cat_features_title' => 'Key Features',
					'cat_features_icon' => 'fa-solid fa-star',
					'cat_features_list' => "Wide range of marine, aerospace, and industrial alloys\nAvailable in various thicknesses and tempers\nFull material certification and complete traceability\nReal-time stock visibility",
					'cat_ideal_title' => 'Ideal For',
					'cat_ideal_icon' => 'fa-solid fa-bullseye',
					'cat_ideal_list' => "Shipbuilding and offshore structures\nAircraft components\nPrecision industrial fabrications",
					'cat_carousel_icon' => 'fa-solid fa-anchor',
					'cat_carousel_subtitle' => 'Marine Grade',
					'cat_carousel_title' => 'Marine Grade Aluminium',
				),
			),
			'structural-grade' => array(
				'name' => 'Structural Grade',
				'fields' => array(
					'cat_badge_text' => 'Structural Range',
					'cat_badge_icon' => 'fa-solid fa-layer-group',
					'cat_section_title' => 'Structural Grade Aluminium',
					'cat_section_description' => 'We supply high-quality structural and engineering aluminium grades designed for general-purpose fabrication, machining, and industrial applications. These versatile alloys offer a good balance of strength, machinability, weldability, and cost-effectiveness.',
					'cat_features_title' => 'Key Features',
					'cat_features_icon' => 'fa-solid fa-star',
					'cat_features_list' => "High strength structural alloys (6000 series)\nExcellent weldability and joint strength\nGood corrosion resistance in atmospheric conditions\nAvailable in plates, sheets, and bars",
					'cat_ideal_title' => 'Ideal For',
					'cat_ideal_icon' => 'fa-solid fa-bullseye',
					'cat_ideal_list' => "Structural frameworks and load-bearing structures\nMachinery bases and mounting plates\nArchitectural trim and framing",
					'cat_carousel_icon' => 'fa-solid fa-building-columns',
					'cat_carousel_subtitle' => 'Structural Grade',
					'cat_carousel_title' => 'Structural Aluminium',
				),
			),
			'aerospace-grade' => array(
				'name' => 'Aerospace Grade',
				'fields' => array(
					'cat_badge_text' => 'Aerospace Range',
					'cat_badge_icon' => 'fa-solid fa-layer-group',
					'cat_section_title' => 'Aerospace Grade Aluminium',
					'cat_section_description' => 'We supply high-strength aerospace and cast aluminium plates engineered for critical applications in aerospace, defence, tooling, and high-performance engineering. These precision plates are manufactured to meet stringent industry standards, offering superior mechanical properties, excellent dimensional stability, and consistent quality.',
					'cat_features_title' => 'Key Features',
					'cat_features_icon' => 'fa-solid fa-star',
					'cat_features_list' => "Ultra-high strength-to-weight ratio (7000 and 2000 series)\nSuperior dimensional stability and low internal stress\nPrecision thickness tolerances and surface flatnesses\nFull aerospace and defense certifications",
					'cat_ideal_title' => 'Ideal For',
					'cat_ideal_icon' => 'fa-solid fa-bullseye',
					'cat_ideal_list' => "Aircraft structural parts and fuselage skins\nPrecision tooling, jigs, and fixtures\nHigh-stress military and aerospace components",
					'cat_carousel_icon' => 'fa-solid fa-plane',
					'cat_carousel_subtitle' => 'Aerospace Grade',
					'cat_carousel_title' => 'Aerospace Aluminium',
				),
			),
			'extrusions-profiles' => array(
				'name' => 'Product Profiles',
				'fields' => array(
					'cat_badge_text' => 'Extrusions & Profiles Range',
					'cat_badge_icon' => 'fa-solid fa-layer-group',
					'cat_section_title' => 'Extrusions & Profiles Aluminium',
					'cat_section_description' => 'We supply a comprehensive range of marine and industrial aluminium extrusions and profiles. Manufactured to tight tolerances, our profiles deliver excellent strength, lightweight properties, and superior corrosion resistance for both structural and architectural applications.',
					'cat_features_title' => 'Key Features',
					'cat_features_icon' => 'fa-solid fa-star',
					'cat_features_list' => "Custom and standard profiles (Angles, Channels, Tees, Flat bars)\nMarine-grade alloys (6082-T6, 6061-T6)\nPrecise dimensions and smooth surface finishes\nExcellent workability and ease of fabrication",
					'cat_ideal_title' => 'Ideal For',
					'cat_ideal_icon' => 'fa-solid fa-bullseye',
					'cat_ideal_list' => "Shipbuilding hull stiffeners, masts, and handrails\nIndustrial conveyor systems and conveyor framing\nArchitectural windows, doors, and partition systems",
					'cat_carousel_icon' => 'fa-solid fa-bezier-curve',
					'cat_carousel_subtitle' => 'Product Profiles',
					'cat_carousel_title' => 'Extrusions & Profiles Aluminium',
				),
			),
			'specialty-grade' => array(
				'name' => 'Specialty Grade',
				'fields' => array(
					'cat_badge_text' => 'Specialty Range',
					'cat_badge_icon' => 'fa-solid fa-layer-group',
					'cat_section_title' => 'Specialty Range Aluminium',
					'cat_section_description' => 'We supply a wide range of special aluminium products and marine-grade accessories designed to meet project-specific requirements. These specialty items complement our core aluminium materials and provide complete solutions for complex marine, offshore, and industrial projects.',
					'cat_features_title' => 'Key Features',
					'cat_features_icon' => 'fa-solid fa-star',
					'cat_features_list' => "Specialty marine-grade fittings and welding consumables\nAnodized and coated sheets for harsh environments\nCustom shapes and fabricated components on request\nNiche alloys for specialized chemical and marine applications",
					'cat_ideal_title' => 'Ideal For',
					'cat_ideal_icon' => 'fa-solid fa-bullseye',
					'cat_ideal_list' => "Corrosive offshore platforms and marine hardware\nArchitectural cladding in severe coastal zones\nCustom machine components and specialized vessels",
					'cat_carousel_icon' => 'fa-solid fa-gem',
					'cat_carousel_subtitle' => 'Specialty Grade',
					'cat_carousel_title' => 'Specialty Range Aluminium',
				),
			),
		),
		'products' => array(
			array('category' => 'marine-grade', 'title' => '5083 H116 / H321 Marine Aluminium', 'slug' => '5083-h116-h321-marine-aluminium', 'legacy_slugs' => array('5083h116-h321-marine-aluminium'), 'status' => 'In Stock', 'image' => 'marine-img-1.jpeg', 'description' => 'Outstanding seawater resistance for hull plates, decks, and welded marine structures.'),
			array('category' => 'marine-grade', 'title' => '5052 H32 Marine Aluminium', 'slug' => '5052-h32-marine-aluminium', 'status' => 'In Stock', 'image' => 'marine-img-2.jpeg', 'description' => 'Strong corrosion resistance and weldability for decking, tanks, panels, and fittings.'),
			array('category' => 'marine-grade', 'title' => 'Aluminium Chequered Plate', 'slug' => 'aluminium-chequered-plate', 'status' => 'In Stock', 'image' => 'marine-img-3.webp', 'description' => 'Non-slip chequered plates for marine decking, walkways, ramps, and industrial flooring.'),
			array('category' => 'marine-grade', 'title' => '5383 H116 / H321 Marine Aluminium', 'slug' => '5383-h116-h321-marine-aluminium', 'status' => 'Indent', 'image' => 'marine-img-4.jpeg', 'description' => 'High strength alloy with excellent corrosion resistance for shipbuilding and offshore structures.'),
			array('category' => 'marine-grade', 'title' => '5086 H116 Marine Aluminium', 'slug' => '5086-h116-marine-aluminium', 'status' => 'Indent', 'image' => 'marine-img-5.jpeg', 'description' => 'Excellent marine corrosion resistance for shipbuilding, offshore, and structural use.'),
			array('category' => 'marine-grade', 'title' => '5754 / 5454 Marine Aluminium', 'slug' => '5754-5454-marine-aluminium', 'status' => 'Indent', 'image' => 'marine-img-6.jpeg', 'description' => 'Superior formability and corrosion resistance for hulls, platforms, and fabricated components.'),
			array('category' => 'structural-grade', 'title' => '6061 T6 / T651 Aluminium', 'slug' => '6061-t6-t651-aluminium', 'status' => 'In Stock', 'image' => 'structural-img-1.webp', 'description' => 'Heat-treatable high strength for frameworks and engineering.'),
			array('category' => 'structural-grade', 'title' => '1100 H14 Aluminium', 'slug' => '1100-h14-aluminium', 'status' => 'In Stock', 'image' => 'structural-img-2.jpeg', 'description' => 'Excellent formability and corrosion resistance for general engineering and semiconductor use.'),
			array('category' => 'structural-grade', 'title' => '6082 T6 / T651 Aluminium', 'slug' => '6082-t6-t651-aluminium', 'status' => 'Indent', 'image' => 'structural-img-3.jpeg', 'description' => 'High strength and excellent machinability for structural frameworks and engineering components.'),
			array('category' => 'structural-grade', 'title' => '3003 H14 Aluminium', 'slug' => '3003-h14-aluminium', 'status' => 'Indent', 'image' => 'structural-img-4.jpeg', 'description' => 'Good formability and corrosion resistance for general engineering and chemical applications.'),
			array('category' => 'aerospace-grade', 'title' => '2024 T3 / T351 Aerospace Aluminium', 'slug' => '2024-t3-t351-aerospace-aluminium', 'status' => 'Indent', 'image' => 'aerospace-img-1.jpeg', 'description' => 'High fatigue resistance for aerospace and high-load marine applications.'),
			array('category' => 'aerospace-grade', 'title' => '7075 T6 / T651 Aerospace Aluminium', 'slug' => '7075-t6-t651-aerospace-aluminium', 'status' => 'Indent', 'image' => 'aerospace-img-2.webp', 'description' => 'Ultra-high strength for aerospace and defence.'),
			array('category' => 'aerospace-grade', 'title' => 'Mic 6 Cast Aluminium Plate', 'slug' => 'mic-6-cast-aluminium-plate', 'status' => 'Indent', 'image' => 'aerospace-img-3.jpeg', 'description' => 'Precision cast plate with excellent dimensional stability and machinability for tooling and base plates.'),
			array('category' => 'extrusions-profiles', 'title' => 'Angle Bar', 'slug' => 'angle-bar', 'status' => 'In Stock', 'image' => 'extrusions-img-1.jpeg', 'description' => 'Equal angle for structural support and corners.'),
			array('category' => 'extrusions-profiles', 'title' => 'Bulb Flat Bar', 'slug' => 'bulb-flat-bar', 'status' => 'In Stock', 'image' => 'extrusions-img-2.jpeg', 'description' => 'Specialized for shipbuilding stiffeners and hull reinforcement.'),
			array('category' => 'extrusions-profiles', 'title' => 'Deck Planking Aluminium', 'slug' => 'deck-planking-aluminium', 'status' => 'In Stock', 'image' => 'extrusions-img-3.jpg', 'description' => 'Non-slip deck profiles for marine vessels and platforms.'),
			array('category' => 'extrusions-profiles', 'title' => 'Flat Bar', 'slug' => 'flat-bar', 'status' => 'In Stock', 'image' => 'extrusions-img-4.jpeg', 'description' => 'Versatile flat sections for general fabrication and framing.'),
			array('category' => 'specialty-grade', 'title' => 'Triplate Transition Joints', 'slug' => 'triplate-transition-joints', 'status' => 'In Stock', 'image' => 'special-img-1.png', 'description' => 'Aluminium-steel transition joints for shipbuilding.'),
			array('category' => 'specialty-grade', 'title' => 'Welding Wire 5183 / 5356', 'slug' => 'welding-wire-5183-5356', 'status' => 'In Stock', 'image' => 'img-600x400-3.jpeg', 'description' => 'High-quality filler wire for marine aluminium welding.'),
			array('category' => 'specialty-grade', 'title' => 'Ceiling Panels Aluminium', 'slug' => 'ceiling-panels-aluminium', 'status' => 'Indent', 'image' => 'img-600x400-4.jpeg', 'description' => 'Perforated and plain panels for marine interiors.'),
			array('category' => 'specialty-grade', 'title' => 'Marine Captain & Passenger Chairs', 'slug' => 'marine-captain-passenger-chairs', 'status' => 'Indent', 'image' => 'aerospace-img-1.jpeg', 'description' => 'Ergonomic aluminium seating for vessels.'),
			array('category' => 'specialty-grade', 'title' => 'Aluminium Fittings', 'slug' => 'aluminium-fittings', 'status' => 'Indent', 'image' => 'img-600x400-2.jpg', 'description' => 'Tee, elbows, reducers and other marine fittings.'),
			array('category' => 'specialty-grade', 'title' => 'Ampligrip Grating', 'slug' => 'ampligrip-grating', 'status' => 'In Stock', 'image' => 'extrusions-img-2.jpeg', 'description' => 'Anti-slip walkways for marine environments.'),
		),
	);
}

function alupro_dynamic_static_product_importer_register_page()
{
	add_submenu_page(
		'edit.php?post_type=aluminium_product',
		__('Import Static Products', 'alupro-dynamic'),
		__('Import Static Products', 'alupro-dynamic'),
		'manage_options',
		'alupro-static-product-importer',
		'alupro_dynamic_static_product_importer_page'
	);
}
add_action('admin_menu', 'alupro_dynamic_static_product_importer_register_page');

function alupro_dynamic_static_product_importer_page()
{
	if (!current_user_can('manage_options')) {
		return;
	}

	$data = alupro_dynamic_static_product_import_data();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('Import Static Products', 'alupro-dynamic'); ?></h1>

		<?php if (isset($_GET['alupro_static_imported'])) : ?>
			<div class="notice notice-success is-dismissible">
				<p>
					<?php
					printf(
						esc_html__('Import complete. Categories: %1$d created, %2$d updated. Products: %3$d created, %4$d updated.', 'alupro-dynamic'),
						absint($_GET['categories_created'] ?? 0),
						absint($_GET['categories_updated'] ?? 0),
						absint($_GET['products_created'] ?? 0),
						absint($_GET['products_updated'] ?? 0)
					);
					?>
				</p>
			</div>
		<?php endif; ?>

		<p><?php esc_html_e('This imports the product category settings and product cards from the static theme into the dynamic Aluminium Products system.', 'alupro-dynamic'); ?></p>
		<p><strong><?php esc_html_e('It does not create or change Appearance menus.', 'alupro-dynamic'); ?></strong></p>

		<ul style="list-style:disc;margin-left:20px;">
			<li><?php printf(esc_html__('%d product categories will be created or updated.', 'alupro-dynamic'), count($data['categories'])); ?></li>
			<li><?php printf(esc_html__('%d products will be created or updated.', 'alupro-dynamic'), count($data['products'])); ?></li>
			<li><?php esc_html_e('Existing imported products are matched by import ID, slug, legacy slug, or exact title where possible.', 'alupro-dynamic'); ?></li>
		</ul>

		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<?php wp_nonce_field('alupro_static_product_import'); ?>
			<input type="hidden" name="action" value="alupro_static_product_import">
			<?php submit_button(__('Import / Update Static Products', 'alupro-dynamic'), 'primary'); ?>
		</form>
	</div>
	<?php
}

function alupro_dynamic_static_product_importer_update_field($name, $value, $object_id)
{
	if (function_exists('update_field')) {
		update_field($name, $value, $object_id);
		return;
	}

	if (is_string($object_id) && 0 === strpos($object_id, 'product_category_')) {
		update_term_meta((int) substr($object_id, strlen('product_category_')), $name, $value);
		return;
	}

	update_post_meta((int) $object_id, $name, $value);
}

function alupro_dynamic_static_product_importer_table_html()
{
	if (function_exists('alupro_dynamic_default_product_editor_table_html')) {
		return alupro_dynamic_default_product_editor_table_html();
	}

	return '<table><thead><tr><th>Thickness</th><th>Width</th><th>Length</th><th>Availability</th></tr></thead><tbody><tr><td rowspan="4">3.0mm</td><td>1220 mm</td><td>2440 mm</td><td>Stock</td></tr><tr><td>1500 mm</td><td>6000 mm</td><td>Stock</td></tr><tr><td>2000 mm</td><td>6000 mm</td><td>Stock</td></tr><tr><td>2200 mm</td><td>9000 mm</td><td>Indent</td></tr></tbody></table><p>&nbsp;</p>';
}

function alupro_dynamic_static_product_importer_find_product($product)
{
	$source_id = 'static:' . $product['category'] . ':' . $product['slug'];
	$matches = get_posts(
		array(
			'post_type' => 'aluminium_product',
			'post_status' => 'any',
			'posts_per_page' => 1,
			'fields' => 'ids',
			'meta_key' => '_alupro_static_import_id',
			'meta_value' => $source_id,
		)
	);

	if (!empty($matches)) {
		return (int) $matches[0];
	}

	$slugs = array_merge(array($product['slug']), isset($product['legacy_slugs']) ? (array) $product['legacy_slugs'] : array());

	foreach ($slugs as $slug) {
		$post = get_page_by_path($slug, OBJECT, 'aluminium_product');

		if ($post) {
			return (int) $post->ID;
		}
	}

	$matches = get_posts(
		array(
			'post_type' => 'aluminium_product',
			'post_status' => 'any',
			'title' => $product['title'],
			'posts_per_page' => 1,
			'fields' => 'ids',
		)
	);

	return !empty($matches) ? (int) $matches[0] : 0;
}

function alupro_dynamic_static_product_importer_import()
{
	if (!current_user_can('manage_options')) {
		wp_die(esc_html__('You do not have permission to import products.', 'alupro-dynamic'));
	}

	check_admin_referer('alupro_static_product_import');

	if (!post_type_exists('aluminium_product') || !taxonomy_exists('product_category')) {
		wp_die(esc_html__('The Aluminium Product post type or Product Category taxonomy is not registered. Activate the dynamic theme and try again.', 'alupro-dynamic'));
	}

	$data = alupro_dynamic_static_product_import_data();
	$term_ids = array();
	$category_order = 0;
	$counts = array(
		'categories_created' => 0,
		'categories_updated' => 0,
		'products_created' => 0,
		'products_updated' => 0,
	);

	foreach ($data['categories'] as $slug => $category) {
		$category_order++;
		$term = get_term_by('slug', $slug, 'product_category');

		if (!$term) {
			$result = wp_insert_term($category['name'], 'product_category', array('slug' => $slug));

			if (is_wp_error($result)) {
				continue;
			}

			$term_id = (int) $result['term_id'];
			$counts['categories_created']++;
		} else {
			$term_id = (int) $term->term_id;
			wp_update_term($term_id, 'product_category', array('name' => $category['name'], 'slug' => $slug));
			$counts['categories_updated']++;
		}

		$term_ids[$slug] = $term_id;
		$acf_object_id = 'product_category_' . $term_id;
		$GLOBALS['wpdb']->update($GLOBALS['wpdb']->terms, array('term_order' => $category_order), array('term_id' => $term_id), array('%d'), array('%d'));

		foreach ($category['fields'] as $field => $value) {
			alupro_dynamic_static_product_importer_update_field($field, $value, $acf_object_id);
		}
	}

	$order_by_category = array();

	foreach ($data['products'] as $product) {
		if (empty($term_ids[$product['category']])) {
			continue;
		}

		$order_by_category[$product['category']] = isset($order_by_category[$product['category']]) ? $order_by_category[$product['category']] + 1 : 1;
		$post_id = alupro_dynamic_static_product_importer_find_product($product);
		$existing_content = $post_id ? get_post_field('post_content', $post_id) : '';
		$post_data = array(
			'post_type' => 'aluminium_product',
			'post_status' => 'publish',
			'post_title' => $product['title'],
			'post_name' => $product['slug'],
			'post_excerpt' => $product['description'],
			'menu_order' => $order_by_category[$product['category']],
		);

		if ($post_id) {
			$post_data['ID'] = $post_id;

			if (false === stripos((string) $existing_content, '<table')) {
				$post_data['post_content'] = alupro_dynamic_static_product_importer_table_html();
			}

			$result = wp_update_post($post_data, true);
			$counts['products_updated']++;
		} else {
			$post_data['post_content'] = alupro_dynamic_static_product_importer_table_html();
			$result = wp_insert_post($post_data, true);
			$counts['products_created']++;
		}

		if (is_wp_error($result)) {
			continue;
		}

		$post_id = (int) $result;
		$image_url = get_theme_file_uri('images/' . $product['image']);
		$source_id = 'static:' . $product['category'] . ':' . $product['slug'];

		wp_set_object_terms($post_id, array((int) $term_ids[$product['category']]), 'product_category', false);
		update_post_meta($post_id, '_alupro_static_import_id', $source_id);
		alupro_dynamic_static_product_importer_update_field('product_status', $product['status'], $post_id);
		alupro_dynamic_static_product_importer_update_field('product_short_desc', $product['description'], $post_id);
		alupro_dynamic_static_product_importer_update_field('product_image', $image_url, $post_id);
	}

	$redirect = add_query_arg(
		array_merge(array('post_type' => 'aluminium_product', 'page' => 'alupro-static-product-importer', 'alupro_static_imported' => 1), $counts),
		admin_url('edit.php')
	);

	wp_safe_redirect($redirect);
	exit;
}
add_action('admin_post_alupro_static_product_import', 'alupro_dynamic_static_product_importer_import');
