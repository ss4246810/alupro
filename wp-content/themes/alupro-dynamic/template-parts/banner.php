<?php
/**
 * Home banner.
 *
 * @package AluProDynamic
 */

$banner_image       = get_theme_mod('banner_image');
$banner_image       = $banner_image ? $banner_image : get_theme_file_uri('images/banner-img-1.webp');
$banner_primary_url = get_theme_mod('banner_primary_url', '#');
?>
<!-- Banner Starts -->
<section class="alupro-home-banner relative min-h-[85vh] flex items-center overflow-hidden bg-[#120A45]">
	<div class="alupro-home-banner__media absolute inset-0 z-0">
		<img
			class="alupro-home-banner__image w-full h-full object-cover opacity-80 contrast-105"
			src="<?php echo esc_url($banner_image); ?>"
			alt="<?php esc_attr_e('Alupro Banner Background', 'alupro-dynamic'); ?>"
		>
		<div class="absolute inset-0 hero-radial"></div>
		<div class="absolute inset-0 bg-gradient-to-r from-[#120A45]/90 via-[#190E5D]/60 to-[#190E5D]/5"></div>
	</div>
	<div class="alupro-home-banner__content relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-20 lg:py-28">
		<div class="max-w-5xl">
			<span class="text-xs font-bold tracking-[0.2em] uppercase text-[#00a2e0] bg-[#00a2e0]/10 border border-[#00a2e0]/15 backdrop-blur-sm px-3 py-1.5 rounded-full inline-block mb-6">
				<?php echo esc_html(get_theme_mod('banner_eyebrow', 'ALUPRO ALLOY | MARINE ALUMINIUM')); ?>
			</span>
			<h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-[1.08] mb-6 text-white drop-shadow-xl">
				<?php echo esc_html(get_theme_mod('banner_title', 'Built for the Sea')); ?> <br>
				<span class="text-[#00a2e0]"><?php echo esc_html(get_theme_mod('banner_title_accent', 'Engineered for Excellence')); ?></span>
			</h1>
			<p class="text-base md:text-xl text-[#E9EAF4] max-w-3xl mb-10 leading-relaxed font-normal">
				<?php echo esc_html(get_theme_mod('banner_description', 'Premium marine-grade aluminium alloys for shipbuilding and offshore structures. Full class society certification with immediate stock in Singapore.')); ?>
			</p>
			<div class="flex flex-col sm:flex-row gap-5">
				<button
					class="bg-[#00a2e0] hover:bg-[#0088c0] text-white px-8 py-3.5 rounded-xl font-bold text-sm uppercase tracking-wide transition-all shadow-xl hover:shadow-2xl cursor-pointer"
					onclick="window.location.href='<?php echo esc_js($banner_primary_url); ?>'"
				>
					<?php echo esc_html(get_theme_mod('banner_primary_text', 'Download Catalogue')); ?>
				</button>
				<button
					type="button"
					class="js-quote-modal-open border border-white/45 hover:border-[#00a2e0] text-white hover:text-[#00a2e0] px-8 py-3.5 rounded-xl font-semibold text-sm uppercase tracking-wide backdrop-blur-sm transition-all cursor-pointer"
				>
					<?php echo esc_html(get_theme_mod('banner_quote_text', 'Request a Quote')); ?>
				</button>
			</div>
		</div>
	</div>
</section>
<!-- Banner Ends -->
