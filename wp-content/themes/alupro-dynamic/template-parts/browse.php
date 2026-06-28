<?php
/**
 * Homepage Browse section.
 *
 * @package AluProDynamic
 */

$front_page_id = get_option('page_on_front');

if (!function_exists('alupro_get_browse_field')) {
	function alupro_get_browse_field($field_name, $default_value, $post_id = null) {
		if (function_exists('get_field')) {
			$val = get_field($field_name, $post_id);
			if (!empty($val)) {
				return $val;
			}
		}
		return $default_value;
	}
}

$browse_title = alupro_get_browse_field('browse_title', 'Browse Aluminium by Industry', $front_page_id);
$browse_desc = alupro_get_browse_field('browse_desc', 'We provide high-performance aluminium solutions tailored to the specific demands of different sectors:', $front_page_id);

// Cards
$cards = array();
for ($i = 1; $i <= 4; $i++) {
	$icon_default = 'fa-solid fa-anchor';
	$title_default = '';
	$desc_default = '';
	$link_default = '#';
	$icon_bg = 'bg-[#EAF7FF]';
	$icon_color = 'text-[#1687C7]';

	if ($i === 1) {
		$icon_default = 'fa-solid fa-anchor';
		$title_default = 'Marine Shipbuilding';
		$desc_default = 'Premium marine-grade aluminium plates, sheets, and extrusions for hull construction, decking, superstructures, and offshore platforms. Built for strength, corrosion resistance, and long-term performance at sea.';
		$link_default = '#sheets-plates-aluminium';
		$icon_bg = 'bg-[#EAF7FF]';
		$icon_color = 'text-[#1687C7]';
	} elseif ($i === 2) {
		$icon_default = 'fa-solid fa-microchip';
		$title_default = 'Precision Semiconductor';
		$desc_default = 'Stable, high-precision aluminium grades ideal for equipment frames, chambers, platforms, and critical components where dimensional stability and cleanliness are essential.';
		$icon_bg = 'bg-[#F2EDFA]';
		$icon_color = 'text-[#8C73B8]';
	} elseif ($i === 3) {
		$icon_default = 'fa-solid fa-industry';
		$title_default = 'General Engineering';
		$desc_default = 'Versatile structural aluminium profiles, bars, plates, and sheets for fabrication, machinery, frameworks, and industrial equipment.';
		$icon_bg = 'bg-[#FFF3D9]';
		$icon_color = 'text-[#C99600]';
	} else {
		$icon_default = 'fa-solid fa-plane';
		$title_default = 'Aerospace Manufacturing';
		$desc_default = 'High-strength aerospace aluminium alloys engineered for critical structural components, offering superior strength-to-weight ratio and reliability.';
		$icon_bg = 'bg-[#EAF0FF]';
		$icon_color = 'text-[#4478D8]';
	}

	$cards[$i] = array(
		'icon'  => alupro_get_browse_field("browse_card_{$i}_icon", $icon_default, $front_page_id),
		'title' => alupro_get_browse_field("browse_card_{$i}_title", $title_default, $front_page_id),
		'desc'  => alupro_get_browse_field("browse_card_{$i}_desc", $desc_default, $front_page_id),
		'link'  => alupro_get_browse_field("browse_card_{$i}_link", $link_default, $front_page_id),
		'bg'    => $icon_bg,
		'color' => $icon_color,
	);
}
?>
<!-- Browse Section Starts -->
<section class="relative overflow-hidden bg-white px-6 py-20 md:py-24">
	<div class="pointer-events-none absolute inset-0 bg-white opacity-[0.03] bg-[linear-gradient(to_right,#000_1px,transparent_1px),linear-gradient(to_bottom,#000_1px,transparent_1px)] bg-[size:72px_72px] [mask-image:linear-gradient(to_bottom,#000_0%,#000_45%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_bottom,#000_0%,#000_45%,transparent_100%)]"></div>
	<div class="relative max-w-7xl mx-auto">
		<div class="relative max-w-7xl mx-auto">
			<div class="mx-auto max-w-3xl text-center">
				<h2 class="mt-6 text-3xl font-extrabold leading-tight text-[#111827] sm:text-4xl lg:text-5xl">
					<?php echo esc_html($browse_title); ?>
				</h2>
				<div class="mx-auto mt-6 h-1 w-16 rounded-full bg-[#00a2e0]"></div>
				<p class="mt-6 text-base leading-8 text-[#4B5563] md:text-lg">
					<?php echo esc_html($browse_desc); ?>
				</p>
			</div>
		</div>

		<div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
			<?php foreach ($cards as $card) : ?>
				<a href="<?php echo esc_url($card['link']); ?>" class="group flex min-h-[280px] flex-col rounded-2xl border border-[#190E5D]/10 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-[#00a2e0]/35 hover:shadow-xl hover:shadow-[#190E5D]/10">
					<div class="flex h-14 w-14 items-center justify-center rounded-xl <?php echo esc_attr($card['bg']); ?> <?php echo esc_attr($card['color']); ?>">
						<i class="<?php echo esc_attr($card['icon']); ?> text-2xl"></i>
					</div>
					<h3 class="mt-7 text-xl font-extrabold leading-tight text-[#111827]">
						<?php echo esc_html($card['title']); ?>
					</h3>
					<p class="mt-4 text-sm font-normal leading-7 text-[#4B5563]">
						<?php echo wp_kses_post($card['desc']); ?>
					</p>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- Browse Section Ends -->
