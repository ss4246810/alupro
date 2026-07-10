<?php

/**
 * Homepage Sheets & Plates Aluminium Section.
 *
 * @package AluProDynamic
 */

$front_page_id = get_option('page_on_front');

if (!function_exists('alupro_get_sheets_field')) {
	function alupro_get_sheets_field($field_name, $default_value, $post_id = null)
	{
		if (function_exists('get_field')) {
			$val = get_field($field_name, $post_id);
			if (!empty($val)) {
				return $val;
			}
		}
		return $default_value;
	}
}

// Section Header fields
$sheets_badge_text = alupro_get_sheets_field('sheets_badge_text', 'Product Range', $front_page_id);
$sheets_badge_icon = alupro_get_sheets_field('sheets_badge_icon', 'fa-solid fa-layer-group', $front_page_id);
$sheets_title = alupro_get_sheets_field('sheets_title', 'Sheets & Plates Aluminium', $front_page_id);
$sheets_description = alupro_get_sheets_field('sheets_description', 'We supply premium-quality aluminium sheets and plates engineered for marine, aerospace, and industrial applications. Manufactured to the highest international standards, these materials offer excellent strength-to-weight ratio, superior corrosion resistance, and long-term durability.', $front_page_id);

// Key Features Box fields
$sheets_features_title = alupro_get_sheets_field('sheets_features_title', 'Key Features', $front_page_id);
$sheets_features_icon = alupro_get_sheets_field('sheets_features_icon', 'fa-solid fa-star', $front_page_id);
$sheets_features_list = alupro_get_sheets_field('sheets_features_list', "Wide range of marine, aerospace, and industrial alloys\nAvailable in various thicknesses and tempers\nFull material certification and complete traceability\nReal-time stock visibility", $front_page_id);
$features = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $sheets_features_list))));

// Ideal For Box fields
$sheets_ideal_title = alupro_get_sheets_field('sheets_ideal_title', 'Ideal For', $front_page_id);
$sheets_ideal_icon = alupro_get_sheets_field('sheets_ideal_icon', 'fa-solid fa-bullseye', $front_page_id);
$sheets_ideal_list = alupro_get_sheets_field('sheets_ideal_list', "Shipbuilding and offshore structures\nAircraft components\nPrecision industrial fabrications", $front_page_id);
$ideal = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $sheets_ideal_list))));

// Carousel Header fields
$sheets_carousel_icon = alupro_get_sheets_field('sheets_carousel_icon', 'fa-solid fa-anchor', $front_page_id);
$sheets_carousel_sub = alupro_get_sheets_field('sheets_carousel_sub', 'Marine Grade', $front_page_id);
$sheets_carousel_title = alupro_get_sheets_field('sheets_carousel_title', 'Marine Grade Aluminium', $front_page_id);

// Populate 6 slides
$slides = array();
for ($i = 1; $i <= 6; $i++) {
	$img_filename = "marine-img-{$i}." . ($i === 3 ? 'webp' : 'jpeg');
	$img_default = get_theme_file_uri("images/{$img_filename}");
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

	$image_url = alupro_get_sheets_field("sheets_slide_{$i}_image", $img_default, $front_page_id);
	$status = alupro_get_sheets_field("sheets_slide_{$i}_status", $status_default, $front_page_id);
	$title = alupro_get_sheets_field("sheets_slide_{$i}_title", $title_default, $front_page_id);
	$desc = alupro_get_sheets_field("sheets_slide_{$i}_desc", $desc_default, $front_page_id);
	$link = alupro_get_sheets_field("sheets_slide_{$i}_link", 'table-pdf.html', $front_page_id);

	if (trim($status) === 'In Stock') {
		$status_class = 'bg-[#047857] text-white';
	} else {
		$status_class = 'bg-[#F4C026] text-[#190E5D]';
	}

	if ($link === 'table-pdf.html') {
		$link_url = home_url('/table-pdf/');
	} else {
		if (!preg_match('/^(https?:|#|\/)/i', $link)) {
			$link_url = home_url('/' . ltrim($link, '/'));
		} else {
			$link_url = $link;
		}
	}

	$slides[] = array(
		'image'        => $image_url,
		'status'       => $status,
		'status_class' => $status_class,
		'title'        => $title,
		'desc'         => $desc,
		'link'         => $link_url,
	);
}
?>
<!-- Sheets & Plates Aluminium Section Starts -->
<section class="materials-showcase relative overflow-hidden bg-[#F8FAFC] px-6 py-16 md:py-24">
	<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#190E5D]/20 to-transparent"></div>
	<div class="relative max-w-7xl mx-auto">
		<div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
			<div>
				<span class="inline-flex items-center gap-2 rounded-full border border-[#00a2e0]/30 bg-[#e6f6fc] px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#1687C7]">
					<?php if ($sheets_badge_icon) : ?>
						<i class="<?php echo esc_attr($sheets_badge_icon); ?>"></i>
					<?php endif; ?>
					<?php echo esc_html($sheets_badge_text); ?>
				</span>
				<h2 class="mt-6 text-2xl md:text-4xl lg:text-5xl font-extrabold leading-tight text-[#111827]">
					<?php echo esc_html($sheets_title); ?>
				</h2>
				<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0]"></div>
				<p class="mt-7 text-base leading-8 text-[#4B5563] md:text-lg">
					<?php echo esc_html($sheets_description); ?>
				</p>
				<div class="mt-8 grid gap-5 lg:grid-cols-2">
					<!-- Key Features -->
					<div class="rounded-2xl border border-[#00a2e0]/20 bg-gradient-to-br from-[#e6f6fc] to-white p-6 shadow-sm">
						<div class="mb-5 flex items-center gap-3">
							<div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#00a2e0] text-white shadow-md shadow-[#00a2e0]/30">
								<i class="<?php echo esc_attr($sheets_features_icon); ?> text-xs"></i>
							</div>
							<h3 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
								<?php echo esc_html($sheets_features_title); ?>
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
								<i class="<?php echo esc_attr($sheets_ideal_icon); ?> text-xs"></i>
							</div>
							<h3 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
								<?php echo esc_html($sheets_ideal_title); ?>
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

		<div id="sheets-plates-aluminium" class="mt-14 flex flex-col gap-6 scroll-mt-[140px] sm:flex-row sm:items-center sm:justify-between">
			<div class="flex items-center gap-4">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#e6f6fc] text-[#00a2e0]">
					<i class="<?php echo esc_attr($sheets_carousel_icon); ?> text-2xl"></i>
				</div>
				<div>
					<p class="text-sm font-bold uppercase tracking-[0.16em] text-[#00a2e0]">
						<?php echo esc_html($sheets_carousel_sub); ?>
					</p>
					<h3 class="text-2xl font-extrabold text-[#190E5D]">
						<?php echo esc_html($sheets_carousel_title); ?>
					</h3>
				</div>
			</div>

			<div class="flex items-center gap-3">
				<button type="button" id="materials-prev" class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl border border-[#190E5D]/10 bg-white text-[#190E5D] shadow-sm transition-all hover:border-[#00a2e0]/40 hover:bg-[#e6f6fc] hover:text-[#00a2e0]" aria-label="Previous product">
					<i class="fa-solid fa-arrow-left"></i>
				</button>
				<button type="button" id="materials-next" class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl border border-[#190E5D]/10 bg-white text-[#190E5D] shadow-sm transition-all hover:border-[#00a2e0]/40 hover:bg-[#e6f6fc] hover:text-[#00a2e0]" aria-label="Next product">
					<i class="fa-solid fa-arrow-right"></i>
				</button>
			</div>
		</div>

		<div id="materials-carousel" class="materials-carousel mt-6 flex gap-6 overflow-x-auto scroll-smooth py-8">
			<?php foreach ($slides as $slide) : ?>
				<a href="<?php echo esc_url($slide['link']); ?>" class="materials-slide group overflow-hidden rounded-2xl border border-[#190E5D]/10 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-[#00a2e0]/35 hover:shadow-xl hover:shadow-[#190E5D]/10">
					<div class="relative h-44 overflow-hidden bg-[#190E5D]">
						<img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" />
						<div class="absolute inset-0 bg-gradient-to-t from-[#120A45]/70 via-[#120A45]/10 to-transparent"></div>
						<?php if (!empty($slide['status'])) : ?>
							<span class="absolute right-4 top-4 rounded-full px-4 py-1.5 text-xs font-bold uppercase <?php echo esc_attr($slide['status_class']); ?>">
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
<!-- Sheets & Plates Aluminium Section Ends -->