<?php
/**
 * Custom services section/page content.
 *
 * @package AluProDynamic
 */

$custom_services_id = function_exists('alupro_get_custom_services_page_id') ? alupro_get_custom_services_page_id() : get_queried_object_id();

if (!function_exists('alupro_get_custom_services_field')) {
	function alupro_get_custom_services_field($field_name, $default_value, $post_id = null) {
		if (function_exists('get_field')) {
			$val = get_field($field_name, $post_id);

			if (!empty($val)) {
				return $val;
			}
		}

		return $default_value;
	}
}

if (!function_exists('alupro_custom_services_lines')) {
	function alupro_custom_services_lines($value) {
		return array_values(
			array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string) $value))
			)
		);
	}
}

$eyebrow = alupro_get_custom_services_field('custom_services_eyebrow', 'Precision Services', $custom_services_id);
$eyebrow_icon = alupro_get_custom_services_field('custom_services_eyebrow_icon', 'fa-solid fa-screwdriver-wrench', $custom_services_id);
$title = alupro_get_custom_services_field('custom_services_title', 'Custom Services for Aluminium', $custom_services_id);
$description = alupro_get_custom_services_field(
	'custom_services_description',
	'We offer high-precision custom processing services for aluminium, tailored to meet the exacting requirements of marine shipbuilding, semiconductor equipment, and high-spec engineering projects. Our advanced fabrication capabilities ensure superior accuracy, efficiency, and quality finish for every component.',
	$custom_services_id
);

$features_title = alupro_get_custom_services_field('custom_services_features_title', 'Key Features', $custom_services_id);
$features = alupro_custom_services_lines(
	alupro_get_custom_services_field(
		'custom_services_features',
		"Fiber laser cutting for clean, precise profiles\nCNC bending and forming\nProfessional TIG/MIG welding\nPlate rolling and curving\nSurface finishing and protective treatments\nFull traceability and quality documentation",
		$custom_services_id
	)
);

$ideal_title = alupro_get_custom_services_field('custom_services_ideal_title', 'Ideal For', $custom_services_id);
$ideal_items = alupro_custom_services_lines(
	alupro_get_custom_services_field(
		'custom_services_ideal',
		"Marine and offshore vessel construction\nSemiconductor manufacturing equipment\nPrecision industrial machinery\nArchitectural and structural aluminium projects\nCustom engineering fabrications",
		$custom_services_id
	)
);

$image = alupro_get_custom_services_field('custom_services_image', get_theme_file_uri('images/custom-service.webp'), $custom_services_id);
$image_status = alupro_get_custom_services_field('custom_services_image_status', 'Available', $custom_services_id);
$image_kicker = alupro_get_custom_services_field('custom_services_image_kicker', 'Precision Cutting & Fabrication', $custom_services_id);
$image_title = alupro_get_custom_services_field(
	'custom_services_image_title',
	'Built to specification for vessels, equipment, and engineered assemblies.',
	$custom_services_id
);
$service_cards = array(
	array(
		'icon' => alupro_get_custom_services_field('custom_services_card_1_icon', 'fa-solid fa-link', $custom_services_id),
		'kicker' => alupro_get_custom_services_field('custom_services_card_1_kicker', 'Shipbuilding', $custom_services_id),
		'title' => alupro_get_custom_services_field('custom_services_card_1_title', 'Triplate transition joints', $custom_services_id),
	),
	array(
		'icon' => alupro_get_custom_services_field('custom_services_card_2_icon', 'fa-solid fa-fire-flame-curved', $custom_services_id),
		'kicker' => alupro_get_custom_services_field('custom_services_card_2_kicker', 'Welding', $custom_services_id),
		'title' => alupro_get_custom_services_field('custom_services_card_2_title', 'Welding wire 5183 / 5356', $custom_services_id),
	),
	array(
		'icon' => alupro_get_custom_services_field('custom_services_card_3_icon', 'fa-solid fa-chair', $custom_services_id),
		'kicker' => alupro_get_custom_services_field('custom_services_card_3_kicker', 'Marine Interior', $custom_services_id),
		'title' => alupro_get_custom_services_field('custom_services_card_3_title', 'Marine aluminium seating', $custom_services_id),
	),
	array(
		'icon' => alupro_get_custom_services_field('custom_services_card_4_icon', 'fa-solid fa-border-all', $custom_services_id),
		'kicker' => alupro_get_custom_services_field('custom_services_card_4_kicker', 'Panels', $custom_services_id),
		'title' => alupro_get_custom_services_field('custom_services_card_4_title', 'Perforated aluminium sheets & ceiling panels', $custom_services_id),
	),
);
?>
<!-- Custom Services Section Starts -->
<section id="custom-services" class="relative overflow-hidden bg-[#120A45] px-6 py-16 text-white md:py-24 scroll-mt-[140px]">
	<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#F4C026]/50 to-transparent"></div>
	<div class="footer-pattern absolute inset-0 opacity-35"></div>
	<div class="relative mx-auto max-w-7xl">
		<div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
			<div class="max-w-full">
				<span class="inline-flex items-center gap-2 rounded-full border border-[#00a2e0]/25 bg-[#00a2e0]/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#00a2e0]">
					<i class="<?php echo esc_attr($eyebrow_icon); ?>"></i>
					<?php echo esc_html($eyebrow); ?>
				</span>
				<h1 class="mt-6 text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl">
					<?php echo esc_html($title); ?>
				</h1>
				<div class="mt-4 h-1 w-16 rounded-full bg-[#00a2e0]"></div>
				<p class="mt-6 max-w-full text-base leading-8 text-[#D8DAEA] md:text-lg">
					<?php echo esc_html($description); ?>
				</p>
			</div>
		</div>

		<div class="mt-8 grid gap-5 lg:grid-cols-2">
			<div class="rounded-2xl border border-[#00a2e0]/20 bg-gradient-to-br from-[#e6f6fc] to-white p-6 shadow-sm">
				<div class="mb-5 flex items-center gap-3">
					<div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#00a2e0] text-white shadow-md shadow-[#00a2e0]/30">
						<i class="fa-solid fa-star text-xs"></i>
					</div>
					<h2 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
						<?php echo esc_html($features_title); ?>
					</h2>
				</div>
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
			</div>

			<div class="rounded-2xl border border-[#190E5D]/15 bg-gradient-to-br from-[#f0eeff] to-white p-6 shadow-sm">
				<div class="mb-5 flex items-center gap-3">
					<div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#190E5D] text-white shadow-md shadow-[#190E5D]/30">
						<i class="fa-solid fa-bullseye text-xs"></i>
					</div>
					<h2 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
						<?php echo esc_html($ideal_title); ?>
					</h2>
				</div>
				<ul class="space-y-3">
					<?php foreach ($ideal_items as $item) : ?>
						<li class="flex items-start gap-3">
							<span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#190E5D] text-white">
								<i class="fa-solid fa-check text-[9px]"></i>
							</span>
							<span class="text-sm leading-relaxed text-[#374151]"><?php echo esc_html($item); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="mt-12 grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-stretch">
			<div class="group relative min-h-[360px] overflow-hidden rounded-2xl border border-white/10 bg-white/10 shadow-2xl shadow-black/25">
				<img
					src="<?php echo esc_url($image); ?>"
					alt="<?php esc_attr_e('Aluminium fabrication services', 'alupro-dynamic'); ?>"
					class="h-full min-h-[360px] w-full object-cover opacity-90 transition-transform duration-700 group-hover:scale-105"
					loading="lazy"
				>
				<div class="absolute inset-0 bg-gradient-to-t from-[#120A45]/90 via-[#120A45]/20 to-transparent"></div>
				<span class="absolute right-5 top-5 rounded-full bg-[#047857] px-4 py-1.5 text-xs font-bold uppercase text-white">
					<?php echo esc_html($image_status); ?>
				</span>
				<div class="absolute bottom-6 left-6 right-6">
					<p class="text-sm font-bold uppercase tracking-[0.18em] text-[#e6f6fc]">
						<?php echo esc_html($image_kicker); ?>
					</p>
					<h2 class="mt-3 max-w-lg text-2xl font-extrabold leading-tight text-white sm:text-3xl">
						<?php echo esc_html($image_title); ?>
					</h2>
				</div>
			</div>

			<div class="grid gap-5 sm:grid-cols-2">
				<?php foreach ($service_cards as $card) : ?>
					<article class="group rounded-2xl border border-white/10 bg-white p-6 text-[#111827] shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#F4C026]/60 hover:shadow-xl hover:shadow-black/20">
						<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#EAF7FF] text-[#1687C7]">
							<i class="<?php echo esc_attr($card['icon']); ?> text-xl"></i>
						</div>
						<p class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-[#1687C7]">
							<?php echo esc_html($card['kicker']); ?>
						</p>
						<h3 class="mt-2 text-xl font-extrabold leading-snug text-[#111827]">
							<?php echo esc_html($card['title']); ?>
						</h3>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<!-- Custom Services Section Ends -->
