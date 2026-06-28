<?php
/**
 * Home/about section.
 *
 * @package AluProDynamic
 */

// Helper to get ACF field with static fallback
$about_id = function_exists('alupro_get_about_page_id') ? alupro_get_about_page_id() : null;


if (!function_exists('alupro_get_about_field')) {
	function alupro_get_about_field($field_name, $default_value, $post_id = null) {
		if (function_exists('get_field')) {
			$val = get_field($field_name, $post_id);
			if (!empty($val)) {
				return $val;
			}
		}
		return $default_value;
	}
}

$about_eyebrow = alupro_get_about_field('about_eyebrow', 'About Us', $about_id);
$about_title = alupro_get_about_field('about_title', 'AluPro <span class="text-[#1687C7]">Alloy Solutions</span>', $about_id);
$about_description_1 = alupro_get_about_field('about_description_1', '<b class="text-black font-bold">AluPro Alloy Solutions Pte Ltd</b> is a Singapore-based stockholder and distributor of certified marine-grade Aluminium Alloys. With over <b class="text-black font-bold">15 years of industry experience</b>, we are guided by our motto, "Excellence in Aluminium Distribution", serving the marine, shipbuilding, offshore, and engineering sectors across Southeast Asia and beyond.', $about_id);
$about_description_2 = alupro_get_about_field('about_description_2', 'Sourced from established global manufacturers, our alloys offer excellent strength-to-weight performance and corrosion resistance for shipbuilding, offshore structures, naval vessels, luxury yachts, and precision engineering.', $about_id);
$about_image = alupro_get_about_field('about_image', get_theme_file_uri('images/marine-img-2.webp'), $about_id);
$about_badges_str = alupro_get_about_field('about_badges', 'ABS, Bureau Veritas, DNV, Lloyd\'s Register', $about_id);
$about_badges = array_map('trim', explode(',', $about_badges_str));

// Stats
$stat_1_val = alupro_get_about_field('about_stat_1_val', '15+', $about_id);
$stat_1_lbl = alupro_get_about_field('about_stat_1_lbl', 'Years Experience', $about_id);
$stat_2_val = alupro_get_about_field('about_stat_2_val', '15+', $about_id);
$stat_2_lbl = alupro_get_about_field('about_stat_2_lbl', 'Alloy Grades Supplies', $about_id);
$stat_3_val = alupro_get_about_field('about_stat_3_val', '4+', $about_id);
$stat_3_lbl = alupro_get_about_field('about_stat_3_lbl', 'Class Approvals', $about_id);
$stat_4_val = alupro_get_about_field('about_stat_4_val', '100%', $about_id);
$stat_4_lbl = alupro_get_about_field('about_stat_4_lbl', 'Material Traceability', $about_id);

// Highlight Cards
$card_1_title = alupro_get_about_field('about_card_1_title', 'Marine & Shipbuilding Aluminium', $about_id);
$card_2_title = alupro_get_about_field('about_card_2_title', 'Precision Engineering & Aerospace Materials', $about_id);
$card_3_title = alupro_get_about_field('about_card_3_title', 'Certified Quality & Full Traceability', $about_id);
?>
<!-- About Section Starts -->
<section class="relative overflow-hidden bg-[#F8FAFC] px-6 py-20 md:py-28">
	<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#190E5D]/20 to-transparent"></div>
	<div class="max-w-7xl mx-auto">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 xl:gap-16 items-center">
			<div>
				<span class="inline-flex items-center gap-2 rounded-full border border-[#00a2e0]/30 bg-[#e6f6fc] px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#1687C7]">
					<i class="fa-solid fa-circle-info"></i><?php echo esc_html($about_eyebrow); ?>
				</span>

				<h2 class="mt-6 text-3xl font-extrabold leading-tight text-[#111827] sm:text-4xl">
					<?php echo wp_kses_post($about_title); ?>
				</h2>
				<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0]"></div>

				<p class="mt-7 text-base leading-8 text-[#4B5563] md:text-base">
					<?php echo wp_kses_post($about_description_1); ?>
				</p>
				<p class="mt-7 text-base leading-8 text-[#4B5563] md:text-base">
					<?php echo wp_kses_post($about_description_2); ?>
				</p>

				<div class="mt-7 flex flex-wrap gap-3">
					<?php foreach ($about_badges as $badge) : ?>
						<?php if (!empty($badge)) : ?>
							<span class="rounded-full border border-[#00a2e0]/30 bg-white px-4 py-2 text-sm font-semibold text-[#1687C7]"><?php echo esc_html($badge); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="relative">
				<img
					src="<?php echo esc_url($about_image); ?>"
					alt="<?php esc_attr_e('Shipbuilding aluminium structure', 'alupro-dynamic'); ?>"
					class="w-full h-[360px] lg:h-[420px] object-cover rounded-2xl shadow-xl"
				>
			</div>
		</div>

		<div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
			<div class="flex flex-col items-center border-b border-[#190E5D]/10 py-4 px-4 text-center lg:border-b-0">
				<span class="text-3xl font-extrabold text-[#190E5D]"><?php echo esc_html($stat_1_val); ?></span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500"><?php echo esc_html($stat_1_lbl); ?></span>
			</div>
			<div class="flex flex-col items-center border-b border-[#190E5D]/10 py-4 px-4 text-center sm:border-l lg:border-b-0 lg:border-l-0">
				<span class="text-3xl font-extrabold text-[#190E5D]"><?php echo esc_html($stat_2_val); ?></span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500"><?php echo esc_html($stat_2_lbl); ?></span>
			</div>
			<div class="flex flex-col items-center border-b border-[#190E5D]/10 py-4 px-4 text-center sm:border-b-0">
				<span class="text-3xl font-extrabold text-[#190E5D]"><?php echo esc_html($stat_3_val); ?></span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500"><?php echo esc_html($stat_3_lbl); ?></span>
			</div>
			<div class="flex flex-col items-center border-[#190E5D]/10 py-4 px-4 text-center sm:border-l lg:border-l-0">
				<span class="text-3xl font-extrabold text-[#190E5D]"><?php echo esc_html($stat_4_val); ?></span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500"><?php echo esc_html($stat_4_lbl); ?></span>
			</div>
		</div>

		<div class="mt-16 grid overflow-hidden rounded-2xl border border-[#190E5D]/10 bg-white shadow-[0_24px_70px_rgba(17,24,39,0.08)] md:grid-cols-3">
			<div class="group flex flex-col lg:flex-row gap-6 p-8 transition-colors md:p-10">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#190E5D] text-white shadow-lg shadow-[#190E5D]/20">
					<i class="fa-solid fa-ship text-xl"></i>
				</div>
				<div>
					<p class="text-lg font-extrabold leading-snug text-[#111827]">
						<?php echo esc_html($card_1_title); ?>
					</p>
					<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0] transition-all duration-300 group-hover:w-24"></div>
				</div>
			</div>

			<div class="group flex flex-col lg:flex-row gap-6 border-t border-[#190E5D]/10 p-8 transition-colors md:border-l md:border-t-0 md:p-10">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#00a2e0] text-white shadow-lg shadow-[#00a2e0]/20">
					<i class="fa-solid fa-gears text-xl"></i>
				</div>
				<div>
					<p class="text-lg font-extrabold leading-snug text-[#111827]">
						<?php echo esc_html($card_2_title); ?>
					</p>
					<div class="mt-5 h-1 w-16 rounded-full bg-[#190E5D] transition-all duration-300 group-hover:w-24"></div>
				</div>
			</div>

			<div class="group flex flex-col lg:flex-row gap-6 border-t border-[#190E5D]/10 p-8 transition-colors md:border-l md:border-t-0 md:p-10">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#111827] text-white shadow-lg shadow-[#111827]/20">
					<i class="fa-solid fa-certificate text-xl"></i>
				</div>
				<div>
					<p class="text-lg font-extrabold leading-snug text-[#111827]">
						<?php echo esc_html($card_3_title); ?>
					</p>
					<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0] transition-all duration-300 group-hover:w-24"></div>
				</div>
			</div>
		</div>

		<?php if (is_page('about-us') || is_page_template('page-about-us.php')) : ?>
			<!-- Additional 2-card grid (Capabilities & QA) unique to the About page -->
			<?php
			$cap_icon = alupro_get_about_field('about_cap_icon', 'fa-solid fa-medal', $about_id);
			$cap_title = alupro_get_about_field('about_cap_title', 'Our Capabilities', $about_id);
			$cap_desc = alupro_get_about_field('about_cap_desc', 'Sourced from established global manufacturers, our alloys offer excellent strength-to-weight performance and corrosion resistance for applications including shipbuilding, offshore structures, naval vessels, luxury yachts, and precision engineering.', $about_id);

			$qa_icon = alupro_get_about_field('about_qa_icon', 'fa-solid fa-handshake', $about_id);
			$qa_title = alupro_get_about_field('about_qa_title', 'Quality Assurance', $about_id);
			$qa_desc = alupro_get_about_field('about_qa_desc', 'AluPro maintains full material traceability and holds approvals from major classification societies, including ABS, Bureau Veritas (BV), DNV, and Lloyd\'s Register (LR), ensuring quality and compliance for the strongest requirements of marine and offshore projects.', $about_id);
			?>
			<div class="mt-12 grid gap-6 md:grid-cols-2">
				<article class="group rounded-2xl border border-[#190E5D]/10 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-[#00a2e0]/35 hover:shadow-xl hover:shadow-[#190E5D]/10">
					<div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#EAF7FF] text-[#1687C7]">
						<i class="<?php echo esc_attr($cap_icon); ?> text-2xl"></i>
					</div>
					<h3 class="mt-6 text-xl font-extrabold text-[#111827]">
						<?php echo esc_html($cap_title); ?>
					</h3>
					<p class="mt-4 text-sm leading-7 text-[#4B5563]">
						<?php echo wp_kses_post($cap_desc); ?>
					</p>
				</article>
				<article class="group rounded-2xl border border-[#190E5D]/10 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-[#00a2e0]/35 hover:shadow-xl hover:shadow-[#190E5D]/10">
					<div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#EAF7FF] text-[#1687C7]">
						<i class="<?php echo esc_attr($qa_icon); ?> text-2xl"></i>
					</div>
					<h3 class="mt-6 text-xl font-extrabold text-[#111827]">
						<?php echo esc_html($qa_title); ?>
					</h3>
					<p class="mt-4 text-sm leading-7 text-[#4B5563]">
						<?php echo wp_kses_post($qa_desc); ?>
					</p>
				</article>
			</div>
		<?php endif; ?>
	</div>
</section>
<!-- About Section Ends -->
