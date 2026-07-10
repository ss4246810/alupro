<?php

/**
 * Template Part: Dynamic Product Sections.
 * Renders all 5 materials-showcase slider sections dynamically.
 *
 * @package AluProDynamic
 */

$category_slugs = array(
	'marine-grade',
	'structural-grade',
	'aerospace-grade',
	'extrusions-profiles',
	'specialty-grade'
);

$carousel_mappings = array(
	'marine-grade' => array(
		'id' => 'sheets-plates-aluminium',
		'carousel_id' => 'materials-carousel',
		'prev_id' => 'materials-prev',
		'next_id' => 'materials-next',
		'slide_class' => 'materials-slide',
	),
	'structural-grade' => array(
		'id' => 'structural-grade-aluminium',
		'carousel_id' => 'structural-carousel',
		'prev_id' => 'structural-prev',
		'next_id' => 'structural-next',
		'slide_class' => 'structural-slide',
	),
	'aerospace-grade' => array(
		'id' => 'aerospace-grade-aluminium',
		'carousel_id' => 'aerospace-carousel',
		'prev_id' => 'aerospace-prev',
		'next_id' => 'aerospace-next',
		'slide_class' => 'aerospace-slide',
	),
	'extrusions-profiles' => array(
		'id' => 'extrusions-profiles-aluminium',
		'carousel_id' => 'extrusions-carousel',
		'prev_id' => 'extrusions-prev',
		'next_id' => 'extrusions-next',
		'slide_class' => 'extrusions-slide',
	),
	'specialty-grade' => array(
		'id' => 'specialty-range-aluminium',
		'carousel_id' => 'specialty-carousel',
		'prev_id' => 'specialty-prev',
		'next_id' => 'specialty-next',
		'slide_class' => 'specialty-slide',
	),
);

$cat_defaults = array(
	'marine-grade' => array(
		'badge_text' => 'Product Range',
		'badge_icon' => 'fa-solid fa-layer-group',
		'title' => 'Sheets & Plates Aluminium',
		'description' => 'We supply premium-quality aluminium sheets and plates engineered for marine, aerospace, and industrial applications. Manufactured to the highest international standards, these materials offer excellent strength-to-weight ratio, superior corrosion resistance, and long-term durability.',
		'features_title' => 'Key Features',
		'features_icon' => 'fa-solid fa-star',
		'features' => array(
			'Wide range of marine, aerospace, and industrial alloys',
			'Available in various thicknesses and tempers',
			'Full material certification and complete traceability',
			'Real-time stock visibility',
		),
		'ideal_title' => 'Ideal For',
		'ideal_icon' => 'fa-solid fa-bullseye',
		'ideal' => array(
			'Shipbuilding and offshore structures',
			'Aircraft components',
			'Precision industrial fabrications',
		),
		'carousel_icon' => 'fa-solid fa-anchor',
		'carousel_subtitle' => 'Marine Grade',
		'carousel_title' => 'Marine Grade Aluminium',
	),
	'structural-grade' => array(
		'badge_text' => 'Structural Range',
		'badge_icon' => 'fa-solid fa-layer-group',
		'title' => 'Structural Grade Aluminium',
		'description' => 'We supply high-quality structural and engineering aluminium grades designed for general-purpose fabrication, machining, and industrial applications. These versatile alloys offer a good balance of strength, machinability, weldability, and cost-effectiveness.',
		'features_title' => 'Key Features',
		'features_icon' => 'fa-solid fa-star',
		'features' => array(
			'High strength structural alloys (6000 series)',
			'Excellent weldability and joint strength',
			'Good corrosion resistance in atmospheric conditions',
			'Available in plates, sheets, and bars',
		),
		'ideal_title' => 'Ideal For',
		'ideal_icon' => 'fa-solid fa-bullseye',
		'ideal' => array(
			'Structural frameworks and load-bearing structures',
			'Machinery bases and mounting plates',
			'Architectural trim and framing',
		),
		'carousel_icon' => 'fa-solid fa-building-columns',
		'carousel_subtitle' => 'Structural Grade',
		'carousel_title' => 'Structural Aluminium',
	),
	'aerospace-grade' => array(
		'badge_text' => 'Aerospace Range',
		'badge_icon' => 'fa-solid fa-layer-group',
		'title' => 'Aerospace Grade Aluminium',
		'description' => 'We supply high-strength aerospace and cast aluminium plates engineered for critical applications in aerospace, defence, tooling, and high-performance engineering. These precision plates are manufactured to meet stringent industry standards, offering superior mechanical properties, excellent dimensional stability, and consistent quality.',
		'features_title' => 'Key Features',
		'features_icon' => 'fa-solid fa-star',
		'features' => array(
			'Ultra-high strength-to-weight ratio (7000 and 2000 series)',
			'Superior dimensional stability and low internal stress',
			'Precision thickness tolerances and surface flatnesses',
			'Full aerospace and defense certifications',
		),
		'ideal_title' => 'Ideal For',
		'ideal_icon' => 'fa-solid fa-bullseye',
		'ideal' => array(
			'Aircraft structural parts and fuselage skins',
			'Precision tooling, jigs, and fixtures',
			'High-stress military and aerospace components',
		),
		'carousel_icon' => 'fa-solid fa-plane',
		'carousel_subtitle' => 'Aerospace Grade',
		'carousel_title' => 'Aerospace Aluminium',
	),
	'extrusions-profiles' => array(
		'badge_text' => 'Extrusions & Profiles Range',
		'badge_icon' => 'fa-solid fa-layer-group',
		'title' => 'Extrusions & Profiles Aluminium',
		'description' => 'We supply a comprehensive range of marine and industrial aluminium extrusions and profiles. Manufactured to tight tolerances, our profiles deliver excellent strength, lightweight properties, and superior corrosion resistance for both structural and architectural applications.',
		'features_title' => 'Key Features',
		'features_icon' => 'fa-solid fa-star',
		'features' => array(
			'Custom and standard profiles (Angles, Channels, Tees, Flat bars)',
			'Marine-grade alloys (6082-T6, 6061-T6)',
			'Precise dimensions and smooth surface finishes',
			'Excellent workability and ease of fabrication',
		),
		'ideal_title' => 'Ideal For',
		'ideal_icon' => 'fa-solid fa-bullseye',
		'ideal' => array(
			'Shipbuilding hull stiffeners, masts, and handrails',
			'Industrial conveyor systems and conveyor framing',
			'Architectural windows, doors, and partition systems',
		),
		'carousel_icon' => 'fa-solid fa-bezier-curve',
		'carousel_subtitle' => 'Product Profiles',
		'carousel_title' => 'Extrusions & Profiles Aluminium',
	),
	'specialty-grade' => array(
		'badge_text' => 'Specialty Range',
		'badge_icon' => 'fa-solid fa-layer-group',
		'title' => 'Specialty Range Aluminium',
		'description' => 'We supply a wide range of special aluminium products and marine-grade accessories designed to meet project-specific requirements. These specialty items complement our core aluminium materials and provide complete solutions for complex marine, offshore, and industrial projects.',
		'features_title' => 'Key Features',
		'features_icon' => 'fa-solid fa-star',
		'features' => array(
			'Specialty marine-grade fittings and welding consumables',
			'Anodized and coated sheets for harsh environments',
			'Custom shapes and fabricated components on request',
			'Niche alloys for specialized chemical and marine applications',
		),
		'ideal_title' => 'Ideal For',
		'ideal_icon' => 'fa-solid fa-bullseye',
		'ideal' => array(
			'Corrosive offshore platforms and marine hardware',
			'Architectural cladding in severe coastal zones',
			'Custom machine components and specialized vessels',
		),
		'carousel_icon' => 'fa-solid fa-gem',
		'carousel_subtitle' => 'Specialty Grade',
		'carousel_title' => 'Specialty Range Aluminium',
	),
);

$slide_defaults = array(
	'marine-grade' => array(
		array('img' => 'marine-img-1.jpeg', 'status' => 'In Stock', 'title' => '5083 H116 / H321 Marine Aluminium', 'desc' => 'Outstanding seawater resistance for hull plates, decks, and welded marine structures.'),
		array('img' => 'marine-img-2.jpeg', 'status' => 'In Stock', 'title' => '5052 H32 Marine Aluminium', 'desc' => 'Strong corrosion resistance and weldability for decking, tanks, panels, and fittings.'),
		array('img' => 'marine-img-3.webp', 'status' => 'In Stock', 'title' => 'Aluminium Chequered Plate', 'desc' => 'Non-slip chequered plates for marine decking, walkways, ramps, and industrial flooring.'),
		array('img' => 'marine-img-4.jpeg', 'status' => 'Indent', 'title' => '5383 H116 / H321 Marine Aluminium', 'desc' => 'High strength alloy with excellent corrosion resistance for shipbuilding and offshore structures.'),
		array('img' => 'marine-img-5.jpeg', 'status' => 'Indent', 'title' => '5086 H116 Marine Aluminium', 'desc' => 'Excellent marine corrosion resistance for shipbuilding, offshore, and structural use.'),
		array('img' => 'marine-img-6.jpeg', 'status' => 'Indent', 'title' => '5754 / 5454 Marine Aluminium', 'desc' => 'Superior formability and corrosion resistance for hulls, platforms, and fabricated components.'),
	),
	'structural-grade' => array(
		array('img' => 'structural-img-1.webp', 'status' => 'In Stock', 'title' => '6061 T6 / T651 Aluminium', 'desc' => 'Heat-treatable high strength for frameworks and engineering.'),
		array('img' => 'structural-img-2.jpeg', 'status' => 'In Stock', 'title' => '1100 H14 Aluminium', 'desc' => 'Excellent formability and corrosion resistance for general engineering and semiconductor use.'),
		array('img' => 'structural-img-3.jpeg', 'status' => 'Indent', 'title' => '6082 T6 / T651 Aluminium', 'desc' => 'High strength and excellent machinability for structural frameworks and engineering components.'),
		array('img' => 'structural-img-4.jpeg', 'status' => 'Indent', 'title' => '3003 H14 Aluminium', 'desc' => 'Good formability and corrosion resistance for general engineering and chemical applications.'),
	),
	'aerospace-grade' => array(
		array('img' => 'aerospace-img-1.jpeg', 'status' => 'Indent', 'title' => '2024 T3 / T351 Aerospace Aluminium', 'desc' => 'High fatigue resistance for aerospace and high-load marine applications.'),
		array('img' => 'aerospace-img-2.webp', 'status' => 'Indent', 'title' => '7075 T6 / T651 Aerospace Aluminium', 'desc' => 'Ultra-high strength for aerospace and defence.'),
		array('img' => 'aerospace-img-3.jpeg', 'status' => 'Indent', 'title' => 'Mic 6 Cast Aluminium Plate', 'desc' => 'Precision cast plate with excellent dimensional stability and machinability for tooling and base plates.'),
	),
	'extrusions-profiles' => array(
		array('img' => 'extrusions-img-1.jpeg', 'status' => 'In Stock', 'title' => 'Angle Bar', 'desc' => 'Equal angle for structural support and corners.'),
		array('img' => 'extrusions-img-2.jpeg', 'status' => 'In Stock', 'title' => 'Bulb Flat Bar', 'desc' => 'Specialized for shipbuilding stiffeners and hull reinforcement.'),
		array('img' => 'extrusions-img-3.jpg', 'status' => 'In Stock', 'title' => 'Deck Planking Aluminium', 'desc' => 'Non-slip deck profiles for marine vessels and platforms.'),
		array('img' => 'extrusions-img-4.jpeg', 'status' => 'In Stock', 'title' => 'Flat Bar', 'desc' => 'Versatile flat sections for general fabrication and framing.'),
	),
	'specialty-grade' => array(
		array('img' => 'special-img-1.png', 'status' => 'In Stock', 'title' => 'Triplate Transition Joints', 'desc' => 'Aluminium-steel transition joints for shipbuilding.'),
		array('img' => 'img-600x400-3.jpeg', 'status' => 'In Stock', 'title' => 'Welding Wire 5183 / 5356', 'desc' => 'High-quality filler wire for marine aluminium welding.'),
		array('img' => 'img-600x400-4.jpeg', 'status' => 'Indent', 'title' => 'Ceiling Panels Aluminium', 'desc' => 'Perforated and plain panels for marine interiors.'),
		array('img' => 'aerospace-img-1.jpeg', 'status' => 'Indent', 'title' => 'Marine Captain & Passenger Chairs', 'desc' => 'Ergonomic aluminium seating for vessels.'),
		array('img' => 'img-600x400-2.jpg', 'status' => 'Indent', 'title' => 'Aluminium Fittings', 'desc' => 'Tee, elbows, reducers and other marine fittings.'),
		array('img' => 'extrusions-img-2.jpeg', 'status' => 'In Stock', 'title' => 'Ampligrip Grating', 'desc' => 'Anti-slip walkways for marine environments.'),
	),
);

// Retrieve categories dynamically
$categories = get_terms(array(
	'taxonomy'   => 'product_category',
	'hide_empty' => false,
	'orderby' => 'term_order',
	'order' => 'ASC',
));

// Loop through each category to output its section
if (!empty($categories) && !is_wp_error($categories)) :
	$rendered_count = 0;
	foreach ($categories as $index => $term) :
		$slug = $term->slug;

		// Query posts of type 'aluminium_product' in this category
		$query_args = array(
			'post_type'      => 'aluminium_product',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_category',
					'field'    => 'slug',
					'terms'    => $slug,
				)
			)
		);
		$products_query = new WP_Query($query_args);

		// Hide the section by default if the admin has not added any product
		if (!$products_query->have_posts()) {
			continue;
		}

		$term_id = 'product_category_' . $term->term_id;
		$defaults = isset($cat_defaults[$slug]) ? $cat_defaults[$slug] : array(
			'badge_text' => 'Product Range',
			'badge_icon' => 'fa-solid fa-layer-group',
			'title' => $term->name,
			'description' => $term->description ? $term->description : sprintf(__('Explore our %s aluminium product range.', 'alupro-dynamic'), $term->name),
			'features_title' => 'Key Features',
			'features_icon' => 'fa-solid fa-star',
			'features' => array(),
			'ideal_title' => 'Ideal For',
			'ideal_icon' => 'fa-solid fa-bullseye',
			'ideal' => array(),
			'carousel_icon' => 'fa-solid fa-layer-group',
			'carousel_subtitle' => $term->name,
			'carousel_title' => $term->name,
		);

		if (isset($carousel_mappings[$slug])) {
			$mapping = $carousel_mappings[$slug];
		} else {
			$anchor_id = function_exists('alupro_dynamic_product_category_anchor_id') ? alupro_dynamic_product_category_anchor_id($term) : 'product-category-' . sanitize_title($slug);
			$mapping = array(
				'id' => $anchor_id,
				'carousel_id' => 'product-carousel-' . sanitize_title($slug),
				'prev_id' => 'product-prev-' . sanitize_title($slug),
				'next_id' => 'product-next-' . sanitize_title($slug),
				'slide_class' => 'product-slide-' . sanitize_title($slug),
			);
		}

		// Retrieve ACF field values with static defaults as fallbacks
		$badge_text = function_exists('get_field') ? get_field('cat_badge_text', $term_id) : '';
		if (empty($badge_text)) {
			$badge_text = $defaults['badge_text'];
		}

		$badge_icon = function_exists('get_field') ? get_field('cat_badge_icon', $term_id) : '';
		if (empty($badge_icon)) {
			$badge_icon = $defaults['badge_icon'];
		}

		$section_title = function_exists('get_field') ? get_field('cat_section_title', $term_id) : '';
		if (empty($section_title)) {
			$section_title = $defaults['title'];
		}

		$section_desc = function_exists('get_field') ? get_field('cat_section_description', $term_id) : '';
		if (empty($section_desc)) {
			$section_desc = $defaults['description'];
		}

		// Features
		$features_title = function_exists('get_field') ? get_field('cat_features_title', $term_id) : '';
		if (empty($features_title)) {
			$features_title = $defaults['features_title'];
		}

		$features_icon = function_exists('get_field') ? get_field('cat_features_icon', $term_id) : '';
		if (empty($features_icon)) {
			$features_icon = $defaults['features_icon'];
		}

		$features_list_raw = function_exists('get_field') ? get_field('cat_features_list', $term_id) : '';
		if (!empty($features_list_raw)) {
			$features = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $features_list_raw))));
		} else {
			$features = $defaults['features'];
		}

		// Ideal For
		$ideal_title = function_exists('get_field') ? get_field('cat_ideal_title', $term_id) : '';
		if (empty($ideal_title)) {
			$ideal_title = $defaults['ideal_title'];
		}

		$ideal_icon = function_exists('get_field') ? get_field('cat_ideal_icon', $term_id) : '';
		if (empty($ideal_icon)) {
			$ideal_icon = $defaults['ideal_icon'];
		}

		$ideal_list_raw = function_exists('get_field') ? get_field('cat_ideal_list', $term_id) : '';
		if (!empty($ideal_list_raw)) {
			$ideal = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $ideal_list_raw))));
		} else {
			$ideal = $defaults['ideal'];
		}

		// Carousel details
		$carousel_icon = function_exists('get_field') ? get_field('cat_carousel_icon', $term_id) : '';
		if (empty($carousel_icon)) {
			$carousel_icon = $defaults['carousel_icon'];
		}

		$carousel_subtitle = function_exists('get_field') ? get_field('cat_carousel_subtitle', $term_id) : '';
		if (empty($carousel_subtitle)) {
			$carousel_subtitle = $defaults['carousel_subtitle'];
		}

		$carousel_title = function_exists('get_field') ? get_field('cat_carousel_title', $term_id) : '';
		if (empty($carousel_title)) {
			$carousel_title = $defaults['carousel_title'];
		}

		// Determine background style and top border gradient (alternating based on rendered sections)
		$is_even = ($rendered_count % 2 === 0);
		$bg_class = $is_even ? 'bg-[#F8FAFC]' : 'bg-white';
		$rendered_count++;

		$slides = array();

		if ($products_query->have_posts()) {
			while ($products_query->have_posts()) {
				$products_query->the_post();
				$pid = get_the_ID();

				$p_status = function_exists('get_field') ? get_field('product_status', $pid) : 'In Stock';
				$p_short_desc = function_exists('get_field') ? get_field('product_short_desc', $pid) : '';
				$p_image = function_exists('get_field') ? get_field('product_image', $pid) : '';
				if (empty($p_image)) {
					// Try post thumbnail
					$p_image = get_the_post_thumbnail_url($pid, 'full');
				}

				$slides[] = array(
					'title'  => get_the_title(),
					'desc'   => $p_short_desc,
					'image'  => $p_image,
					'status' => $p_status,
					'link'   => get_permalink(),
				);
			}
			wp_reset_postdata();
		} else {
			// Fallback to default slides
			foreach (isset($slide_defaults[$slug]) ? $slide_defaults[$slug] : array() as $def_slide) {
				$slides[] = array(
					'title'  => $def_slide['title'],
					'desc'   => $def_slide['desc'],
					'image'  => get_theme_file_uri('images/' . $def_slide['img']),
					'status' => $def_slide['status'],
					'link'   => '#',
				);
			}
		}
?>
		<!-- <?php echo esc_html($term->name); ?> Section Starts -->
		<section class="materials-showcase relative overflow-hidden <?php echo esc_attr($bg_class); ?> px-6 py-16 md:py-24">
			<?php if ($is_even) : ?>
				<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#190E5D]/20 to-transparent"></div>
			<?php endif; ?>
			<div class="relative max-w-7xl mx-auto">
				<div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
					<div>
						<span class="inline-flex items-center gap-2 rounded-full border border-[#00a2e0]/30 bg-[#e6f6fc] px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#1687C7]">
							<?php if ($badge_icon) : ?>
								<i class="<?php echo esc_attr($badge_icon); ?>"></i>
							<?php endif; ?>
							<?php echo esc_html($badge_text); ?>
						</span>
						<h2 class="mt-6 text-2xl md:text-4xl lg:text-5xl font-extrabold leading-tight text-[#111827]">
							<?php echo esc_html($section_title); ?>
						</h2>
						<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0]"></div>
						<p class="mt-7 text-base leading-8 text-[#4B5563] md:text-lg">
							<?php echo esc_html($section_desc); ?>
						</p>
						<div class="mt-8 grid gap-5 lg:grid-cols-2">
							<!-- Key Features -->
							<div class="rounded-2xl border border-[#00a2e0]/20 bg-gradient-to-br from-[#e6f6fc] to-white p-6 shadow-sm">
								<div class="mb-5 flex items-center gap-3">
									<div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#00a2e0] text-white shadow-md shadow-[#00a2e0]/30">
										<i class="<?php echo esc_attr($features_icon); ?> text-xs"></i>
									</div>
									<h3 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
										<?php echo esc_html($features_title); ?>
									</h3>
								</div>
								<?php if (!empty($features)) : ?>
									<ul class="space-y-3">
										<?php foreach ($features as $feature) : ?>
											<li class="flex items-start gap-3">
												<span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#00a2e0] text-white">
													<i class="fa-solid fa-check text-[9px]"></i>
												</span>
												<span class="text-sm leading-relaxed text-[#374151]"><?php echo esc_html($feature); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>

							<!-- Ideal For -->
							<div class="rounded-2xl border border-[#190E5D]/15 bg-gradient-to-br from-[#f0eeff] to-white p-6 shadow-sm">
								<div class="mb-5 flex items-center gap-3">
									<div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#190E5D] text-white shadow-md shadow-[#190E5D]/30">
										<i class="<?php echo esc_attr($ideal_icon); ?> text-xs"></i>
									</div>
									<h3 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
										<?php echo esc_html($ideal_title); ?>
									</h3>
								</div>
								<?php if (!empty($ideal)) : ?>
									<ul class="space-y-3">
										<?php foreach ($ideal as $item) : ?>
											<li class="flex items-start gap-3">
												<span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#190E5D] text-white">
													<i class="fa-solid fa-check text-[9px]"></i>
												</span>
												<span class="text-sm leading-relaxed text-[#374151]"><?php echo esc_html($item); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<div id="<?php echo esc_attr($mapping['id']); ?>" class="mt-14 flex flex-col gap-6 scroll-mt-[140px] sm:flex-row sm:items-center sm:justify-between">
					<div class="flex items-center gap-4">
						<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#e6f6fc] text-[#00a2e0]">
							<i class="<?php echo esc_attr($carousel_icon); ?> text-2xl"></i>
						</div>
						<div>
							<p class="text-sm font-bold uppercase tracking-[0.16em] text-[#00a2e0]">
								<?php echo esc_html($carousel_subtitle); ?>
							</p>
							<h3 class="text-2xl font-extrabold text-[#190E5D]">
								<?php echo esc_html($carousel_title); ?>
							</h3>
						</div>
					</div>

					<div class="flex items-center gap-3">
						<button type="button" id="<?php echo esc_attr($mapping['prev_id']); ?>" class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl border border-[#190E5D]/10 bg-white text-[#190E5D] shadow-sm transition-all hover:border-[#00a2e0]/40 hover:bg-[#e6f6fc] hover:text-[#00a2e0]" aria-label="Previous product">
							<i class="fa-solid fa-arrow-left"></i>
						</button>
						<button type="button" id="<?php echo esc_attr($mapping['next_id']); ?>" class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl border border-[#190E5D]/10 bg-white text-[#190E5D] shadow-sm transition-all hover:border-[#00a2e0]/40 hover:bg-[#e6f6fc] hover:text-[#00a2e0]" aria-label="Next product">
							<i class="fa-solid fa-arrow-right"></i>
						</button>
					</div>
				</div>

				<div
					id="<?php echo esc_attr($mapping['carousel_id']); ?>"
					class="<?php echo esc_attr($mapping['carousel_id']); ?> product-carousel mt-6 flex gap-6 overflow-x-auto scroll-smooth py-8"
					data-product-carousel
					data-prev-id="<?php echo esc_attr($mapping['prev_id']); ?>"
					data-next-id="<?php echo esc_attr($mapping['next_id']); ?>"
					data-slide-selector=".product-slide">
					<?php foreach ($slides as $slide) :
						$status_class = (trim($slide['status']) === 'In Stock') ? 'bg-[#047857] text-white' : 'bg-[#F4C026] text-[#190E5D]';
					?>
						<a href="<?php echo esc_url($slide['link']); ?>" class="<?php echo esc_attr($mapping['slide_class']); ?> product-slide group overflow-hidden rounded-2xl border border-[#190E5D]/10 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-[#00a2e0]/35 hover:shadow-xl hover:shadow-[#190E5D]/10">
							<div class="relative h-44 overflow-hidden bg-[#190E5D]">
								<?php if ($slide['image']) : ?>
									<img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" />
								<?php endif; ?>
								<div class="absolute inset-0 bg-gradient-to-t from-[#120A45]/70 via-[#120A45]/10 to-transparent"></div>
								<?php if (!empty($slide['status'])) : ?>
									<span class="absolute right-4 top-4 rounded-full px-4 py-1.5 text-xs font-bold uppercase <?php echo esc_attr($status_class); ?>">
										<?php echo esc_html($slide['status']); ?>
									</span>
								<?php endif; ?>
							</div>
							<div class="p-6">
								<h4 class="text-xl font-extrabold leading-snug text-[#111827]">
									<?php echo esc_html($slide['title']); ?>
								</h4>
								<p class="mt-4 text-sm leading-6 text-[#4B5563]">
									<?php echo esc_html($slide['desc']); ?>
								</p>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<!-- <?php echo esc_html($term->name); ?> Section Ends -->
<?php
	endforeach;
endif;
